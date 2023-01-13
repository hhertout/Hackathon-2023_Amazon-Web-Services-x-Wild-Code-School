<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Vehicle;
use App\Form\SearchFormType;
use App\Form\ReservationType;
use App\Service\CalculateDistance;
use App\Repository\CompanyRepository;
use App\Repository\ReservationRepository;
use App\Repository\VehicleRepository;
use App\Service\HereMapAPI;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function userCompany(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $company = $user->getCompany();

        return $this->render('components/_userCompany.html.twig', [
            'company' => $company
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request, VehicleRepository $vehicleRepository, CalculateDistance $calculateDistance, CompanyRepository $companyRepository): Response
    {
        // IL FAUT UTILISER IS GRANTED
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        $otherNearCompagnies = [];
        $otherNearCompagniesVehicles = [];
        $vehicles = [];
        if ($form->isSubmitted()) {
            $carId = [];
            $energyArray = ['Diesel', 'Electric', 'Gasoline'];
            $brandArray = ['Peugeot', 'Citroën', 'Renault', 'Volkswagen', 'BMW', 'Mercedes', 'Hyundai', 'Audi', 'Opel', 'Toyota', 'Ford', 'Honda', 'DS'];
            $doorArray = ['3', '5'];
            $gearboxArray = ['Automatic', 'Manual'];
            $startDate = $form->getData()['startDate'];
            $endDate = $form->getData()['endDate'];
            $sharable = $form->getData()['shared'];

            if ($endDate && $startDate) {
                //J'enregistre les dates en session pour les enregistrer dans l'order
                $session = $request->getSession();
                $session->set('vehicleRentDateStart', $startDate);
                $session->set('vehicleRentEndDate', $endDate);
            } else {
                throw new Exception('Veuillez sélectionner une date de départ et d\'arriver');
            }

            $vehicles = $vehicleRepository->findAll();
            foreach ($vehicles as $vehicle) {
                $vehicleRent = $vehicle->getReservations();
                if ($vehicleRent->isEmpty()) {
                    $carId[] = $vehicle->getId();
                }
                foreach ($vehicleRent as $rent) {
                    $vehiculeRentDateStart = $rent->getRentedDate();
                    $vehiculeRentDateEnd = $rent->getReturnDate();

                    if (!($startDate <= $vehiculeRentDateEnd && $endDate >= $vehiculeRentDateStart)) {
                        $carId[] = $rent->getVehicle()->getId();
                    }
                }
            }

            $brand = $form->getData()['Brand'];
            $energy = $form->getData()['energy'];
            $gearbox = $form->getData()['gearbox'];
            $doorNumber = $form->getData()['door'];

            if ($sharable === true) {
                $nearCompanies = $calculateDistance->checkDistances($user->getCompany(), $companyRepository->findAll());
                foreach ($nearCompanies as $nearCompagny) {
                    if ($nearCompagny->getId() !== $user->getCompany()->getId()) {
                        $otherNearCompagnies[] = $nearCompagny;
                    }
                }

                foreach ($otherNearCompagnies as $otherNearCompagny) {
                    $otherNearCompagniesVehicles = array_merge($otherNearCompagniesVehicles, $vehicleRepository->findBy([
                        'company' => $otherNearCompagny,
                        'is_shared' => true,
                        'isAvailable' => true,
                    ]));
                }
            }
            $vehicles = $vehicleRepository->findBy([
                'id' => $carId,
                'company' => $user->getCompany(),
                'isAvailable' => true,
                'brand' => $brand ?? $brandArray,
                'energy' => $energy ?? $energyArray,
                'gearbox' => $gearbox ?? $gearboxArray,
                'nbDoor' => $doorNumber ?? $doorArray
            ]);
        }

        return $this->render('home/index.html.twig', [
            'searchForm' => $form->createView(),
            'vehicles' => $vehicles ?? [],
            'init' => 'Enter dates to get starded',
            'otherNearCompagniesVehicles' => $otherNearCompagniesVehicles ?? []
        ]);
    }

    #[Route('/reserve/{vehicle}', name: 'app_show')]
    public function showOrder(Request $request, Vehicle $vehicle, ReservationRepository $reservationRepository, HereMapAPI $hereMapAPI, VehicleRepository $vehicleRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $session = $request->getSession();
        $vehicleRentDateStart = $session->get('vehicleRentDateStart');
        $vehicleRentEndDate = $session->get('vehicleRentEndDate');
        if ($request->getMethod() === 'POST') {
            $destination = $request->get('destination');
            $reservation = new Reservation();
            $reservation->setRentedDate($vehicleRentDateStart);
            $reservation->setReturnDate($vehicleRentEndDate);
            $reservation->setUser($this->getUser());
            $reservation->setVehicle($vehicle);
            $reservation->setDestination($destination);
            $reservation->setLatitude($hereMapAPI->geolocateViaAddress($destination)['lat']);
            $reservation->setLongitude($hereMapAPI->geolocateViaAddress($destination)['lng']);
            if ($user->getCompany() !== $vehicle->getCompany()) {
                $reservation->setOwner($vehicle->getCompany());
                $vehicle->setIsSharedNow(true);
                $vehicle->setIsShared(false);
            }

            $reservationRepository->save($reservation, true);
            $vehicle->setIsAvailable(false);
            $vehicleRepository->save($vehicle, true);

            $session->remove('vehicleRentDateStart');
            $session->remove('vehicleRentEndDate');
            $this->addFlash('success', 'Your order has been registered');
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('company/newReservation.html.twig', [
            'vehicle' => $vehicle,
            'vehicleRentDateStart' => $vehicleRentDateStart,
            'vehicleRentEndDate' => $vehicleRentEndDate,
        ]);
    }
}
