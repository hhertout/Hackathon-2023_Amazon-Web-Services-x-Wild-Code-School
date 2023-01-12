<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\CompanyRepository;
use App\Repository\VehicleRepository;
use App\Service\CalculateDistance;
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
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);
        $nearCompaniesVehicles = [];
        $otherNearCompagnies = [];
        $otherNearCompagniesVehicles = [];
        if ($form->isSubmitted()) {
            $carId = [];
            $energyArray = ['Diesel', 'Electric', 'Gasoline'];
            $brandArray = ['Peugeot', 'Citroën', 'Renault', 'Volkswagen', 'BMW', 'Mercedes', 'Hyundai', 'Audi', 'Opel', 'Toyota', 'Ford', 'Honda', 'DS',];
            $startDate = $form->getData()['startDate'];
            $endDate = $form->getData()['endDate'];
            $sharable = $form->getData()['shared'];

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
                        'is_shared' => true
                    ]));
                }
            }
            $vehicles = $vehicleRepository->findBy([
                'id' => $carId,
                'company' => $user->getCompany(),
                'isAvailable' => true,
                'brand' => $brand ?? $brandArray,
                'energy' => $energy ?? $energyArray
            ]);
        } else {
            $vehicles = $vehicleRepository->findBy(['company' => $user->getCompany(), 'isAvailable' => true,]);
        }
        return $this->render('home/index.html.twig', [
            'searchForm' => $form->createView(),
            'vehicles' => $vehicles,
            'otherNearCompagniesVehicles' => $otherNearCompagniesVehicles ?? []
        ]);
    }
}
