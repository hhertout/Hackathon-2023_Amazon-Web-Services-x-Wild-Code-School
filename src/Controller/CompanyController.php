<?php

namespace App\Controller;

use DateTime;
use App\Entity\Company;
use App\Entity\Vehicle;
use App\Form\VehicleType;
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
    public function index(Company $company, VehicleRepository $vehicleRepository): Response
    {
        $companyId = $company->getId();
        $carsCompany = $vehicleRepository->findBy(['company' => $companyId]);
        $numberOfCar = count($carsCompany);
        return $this->render('company/index.html.twig', [
            'company' => $company,
            'numberOfCar' => $numberOfCar
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
        $vehicles = $vehicleRepository->findBy(['company' => $companyId, 'is_shared' => true]);

        return $this->render('company/fleetSharable.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/fleet/notsharable', name: 'app_company_fleet_notsharable', methods: ['GET'])]
    public function fleetnotSharable(Company $company, VehicleRepository $vehicleRepository): Response
    {
        $companyId = $company->getId();
        $vehicles = $vehicleRepository->findBy(['company' => $companyId, 'is_shared' => false]);

        return $this->render('company/fleetNotSharable.html.twig', [
            'company' => $company,
            'vehicles' => $vehicles
        ]);
    }
    #[Route('/request', name: 'app_company_request', methods: ['GET'])]
    public function request(Company $company): Response
    {
        return $this->render('company/reservationRequest.html.twig', [
            'company' => $company
        ]);
    }
    #[Route('/statistics', name: 'app_company_statistic', methods: ['GET'])]
    public function statistics(Company $company, ChartBuilderInterface $chartBuilder, VehicleRepository $vehicleRepository): Response
    {
        $vehicles = $vehicleRepository->findBy(['company' => $company->getId()]);
        $vehiculeCount = count($vehicles);
        $availableVehicules = count($vehicleRepository->findBy(['company' => $company->getId(), 'isAvailable' => true]));
        $sharedVehicules = count($vehicleRepository->findBy(['company' => $company->getId(), 'is_shared' => true ]));
        $kaputVehicules = count($vehicleRepository->findBy(['company' => $company->getId(), 'is_kaput' => true]));

        $availablePercent = $availableVehicules / $vehiculeCount * 100;
        $sharedPercent = $sharedVehicules / $vehiculeCount * 100;
        $kaputPercent = $kaputVehicules / $vehiculeCount * 100;

        dump($sharedVehicules, $kaputVehicules);
    
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
                    'label' => 'Kaput',
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

    #[Route('/vehicle/new', name: 'app_vehicle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehicleRepository $vehicleRepository, Company $company): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicle->setCompany($company);
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
            $vehicleRepository->save($vehicle, true);


            return $this->redirectToRoute('app_company_home', ['company' => $vehicle->getCompany()->getId()], Response::HTTP_SEE_OTHER);
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
