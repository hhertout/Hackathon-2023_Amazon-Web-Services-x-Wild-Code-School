<?php

namespace App\Controller;

use DateTime;
use App\Entity\Company;
use App\Entity\Reservation;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\CompanyRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dashboard/{company}')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'app_company_home', methods: ['GET'])]
    public function index(Company $company, VehicleRepository $vehicleRepository, ReservationRepository $reservationRepository): Response
    {
        $companyId = $company->getId();
        $carsCompany = $vehicleRepository->findBy(['company' => $companyId]);
        $reservationNumber = count($reservationRepository->findBy(['vehicle' => $carsCompany]));
        $numberOfCar = count($carsCompany);
        return $this->render('company/index.html.twig', [
            'company' => $company,
            'numberOfCar' => $numberOfCar,
            'reservationNumber' => $reservationNumber,
            'sharedCar' => count($vehicleRepository->findBy(['company' => $companyId, 'isSharedNow' => true]))
        ]);
    }
    #[Route('/fleet', name: 'app_company_fleet', methods: ['GET'])]
    public function fleet(Company $company): Response
    {
        $vehicles = $company->getVehicles();
        return $this->render('company/fleet.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/fleet/available', name: 'app_company_fleet_available', methods: ['GET'])]
    public function fleetAvailable(Company $company, VehicleRepository $vehicleRepository): Response
    {
        $companyId = $company->getId();
        $vehicles = $vehicleRepository->findBy(['company' => $companyId, 'isAvailable' => true]);

        return $this->render('company/fleetAvailable.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/fleet/unavailable', name: 'app_company_fleet_unavailable', methods: ['GET'])]
    public function fleetUnAvailable(Company $company, VehicleRepository $vehicleRepository): Response
    {
        $companyId = $company->getId();
        $vehicles = $vehicleRepository->findBy(['company' => $companyId, 'isAvailable' => false]);

        return $this->render('company/fleetUnAvailable.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/fleet/sharable', name: 'app_company_fleet_sharable', methods: ['GET'])]
    public function fleetSharable(Company $company, VehicleRepository $vehicleRepository): Response
    {
        $companyId = $company->getId();
        $vehicles = $vehicleRepository->findBy(['company' => $companyId, 'isSharedNow' => true]);

        return $this->render('company/fleetSharable.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/fleet/notsharable', name: 'app_company_fleet_notsharable', methods: ['GET'])]
    public function fleetnotSharable(Company $company, VehicleRepository $vehicleRepository): Response
    {
        $companyId = $company->getId();
        $vehicles = $vehicleRepository->findBy(['company' => $companyId, 'isSharedNow' => false]);

        return $this->render('company/fleetNotSharable.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/request', name: 'app_company_request')]
    public function request(Company $company, ReservationRepository $reservationRepository, Request $request): Response
    {
        $reservations = $reservationRepository->findBy(['owner' => $company]);
        if ($request->getMethod() === 'POST') {
            $isApproved = $request->get('validate');
            $isRejected =  $request->get('reject');
            $reservationId =  $request->get('reservation-id');
            $reservation = $reservationRepository->findOneBy(['id' => $reservationId]);
            if ($isApproved === 'Validate') {
                $reservation->setState(true);
                $reservationRepository->save($reservation, true);
            } elseif ($isRejected === 'Reject') {
                $reservation->setState(false);
                $reservationRepository->save($reservation, true);
            }
            return $this->redirectToRoute('app_company_request', ['company' => $company->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('company/reservationRequest.html.twig', [
            'company' => $company,
            'reservations' => $reservations
        ]);
    }

    #[Route('/orders', name: 'app_company_orders')]
    public function orders(Company $company, ReservationRepository $reservationRepository, UserRepository $userRepository, Request $request): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $users = $userRepository->findBy(['company' => $company]);
        foreach ($users as $user) {
            $reservations = $reservationRepository->findBy(['user' => $user]);
        }

        return $this->render('company/orders.html.twig', [
            'company' => $company,
            'reservations' => $reservations
        ]);
    }

    #[Route('/statistics', name: 'app_company_statistic', methods: ['GET'])]
    public function statistics(Company $company, ChartBuilderInterface $chartBuilder, VehicleRepository $vehicleRepository): Response
    {
        $vehicles = $vehicleRepository->findBy(['company' => $company->getId()]);
        $vehiculeCount = count($vehicles);
        $availableVehicules = count($vehicleRepository->findBy(['company' => $company->getId(), 'isAvailable' => true]));
        $sharedVehicules = count($vehicleRepository->findBy(['company' => $company->getId(), 'isSharedNow' => true]));
        $kaputVehicules = count($vehicleRepository->findBy(['company' => $company->getId(), 'is_kaput' => true]));

        $availablePercent = $availableVehicules / $vehiculeCount * 100;
        $sharedPercent = $sharedVehicules / $vehiculeCount * 100;
        $kaputPercent = $kaputVehicules / $vehiculeCount * 100;

        $chartIsAvailable = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chartIsAvailable->setData([
            'labels' => ['Vehicles Available (%)', 'Vehicles Not Available (%)'],
            'datasets' => [
                [
                    'label' => 'Available',
                    'backgroundColor' => [
                        'green',
                        'red'
                    ],
                    'data' => [$availablePercent, 100 - $availablePercent],
                    "hoverOffset" => 8
                ],
            ],
        ]);
        $chartIsShared = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chartIsShared->setData([
            'labels' => ['Vehicles Shared (%)', 'Vehicles Not Shared (%)'],
            'datasets' => [
                [
                    'label' => 'Shared',
                    'backgroundColor' => [
                        'green',
                        'red'
                    ],
                    'data' => [$sharedPercent, 100 - $sharedPercent],
                    "hoverOffset" => 4
                ],
            ],
        ]);
        $chartIsKaput = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chartIsKaput->setData([
            'labels' => ['Vehicles In Maintenance (%)', 'Vehicles In Service (%)'],
            'datasets' => [
                [
                    'label' => 'In Maintenance',
                    'backgroundColor' => [
                        'red',
                        'green'
                    ],
                    'data' => [$kaputPercent, 100 - $kaputPercent],
                    "hoverOffset" => 4
                ],
            ],
        ]);

        return $this->render('company/stats.html.twig', [
            'company' => $company,
            'chartIsAvailable' => $chartIsAvailable,
            'chartIsShared' => $chartIsShared,
            'chartIsKaput' => $chartIsKaput
        ]);
    }
    #[Route('/reservations-statistics', name: 'app_company_reserv_statistic', methods: ['GET'])]
    public function statisticsReservation(Company $company, ChartBuilderInterface $chartBuilder, ReservationRepository $reservationRepository): Response
    {
        $dateTime = new DateTime();
        $dateTime = $dateTime->format('M-Y');
        $dateTime1last = new DateTime('-1 month');
        $dateTime1last = $dateTime1last->format('M-Y');
        $dateTime2last = new DateTime('-2 month');
        $dateTime2last = $dateTime2last->format('M-Y');
        $dateTime3last = new DateTime('-3 month');
        $dateTime3last = $dateTime3last->format('M-Y');
        $dateTime4last = new DateTime('-4 month');
        $dateTime4last = $dateTime4last->format('M-Y');
        $dateTime5last = new DateTime('-5 month');
        $dateTime5last = $dateTime5last->format('M-Y');
        $dateTime6last = new DateTime('-6 month');
        $dateTime6last = $dateTime6last->format('M-Y');
        $dateTime7last = new DateTime('-7 month');
        $dateTime7last = $dateTime7last->format('M-Y');
        $dateTime8last = new DateTime('-8 month');
        $dateTime8last = $dateTime8last->format('M-Y');
        $dateTime9last = new DateTime('-9 month');
        $dateTime9last = $dateTime9last->format('M-Y');
        $dateTime10last = new DateTime('-10 month');
        $dateTime10last = $dateTime10last->format('M-Y');
        $dateTime11last = new DateTime('-11 month');
        $dateTime11last = $dateTime11last->format('M-Y');
        $dateTime12last = new DateTime('-12 month');
        $dateTime12last = $dateTime12last->format('M-Y');

        $chartReservation = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chartReservation->setData([
            'labels' => [
                $dateTime,
                $dateTime1last,
                $dateTime2last,
                $dateTime3last,
                $dateTime4last,
                $dateTime5last,
                $dateTime6last,
                $dateTime7last,
                $dateTime8last,
                $dateTime9last,
                $dateTime10last,
                $dateTime11last,
                $dateTime12last,
            ],
            'datasets' => [
                [
                    'label' => ['Number of reservations'],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(201, 203, 207, 0.8)'
                    ],
                    'data' => [
                        count($reservationRepository->findBy(['rentedDate' => new DateTime()])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-1 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-2 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-3 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-4 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-5 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-6 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-7 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-8 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-9 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-10 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-11 month')])),
                        count($reservationRepository->findBy(['rentedDate' => new DateTime('-12 month')])),
                    ],
                    "hoverOffset" => 8
                ],
            ],
        ]);

        return $this->render('company/reserv_stats.html.twig', [
            'company' => $company,
            'chartReservation' => $chartReservation,
        ]);
    }

    #[Route('/vehicle/new', name: 'app_vehicle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehicleRepository $vehicleRepository, Company $company): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setCompany($company);
            $vehicle->setIsSharedNow(false);
            $vehicleRepository->save($vehicle, true);

            return $this->redirectToRoute('app_company_home', ['company' => $company->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
            'company' => $company
        ]);
    }

    #[Route('vehicle/{vehicle}', name: 'app_vehicle_show', methods: ['GET'])]
    public function show(Vehicle $vehicle, Company $company): Response
    {
        return $this->render('vehicle/show.html.twig', [
            'vehicle' => $vehicle,
        ]);
    }

    #[Route('vehicle/{vehicle}/edit', name: 'app_vehicle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicle $vehicle, VehicleRepository $vehicleRepository, Company $company): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setIsSharedNow(false);
            $vehicleRepository->save($vehicle, true);


            return $this->redirectToRoute('app_company_fleet', ['company' => $vehicle->getCompany()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form,
        ]);
    }

    #[Route('vehicle/{vehicle}/delete', name: 'app_vehicle_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicle $vehicle, VehicleRepository $vehicleRepository, Company $company): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vehicle->getId(), $request->request->get('_token'))) {
            $vehicleRepository->remove($vehicle, true);
        }

        return $this->redirectToRoute('app_company_fleet', ['company' => $vehicle->getCompany()->getId()], Response::HTTP_SEE_OTHER);
    }
}
