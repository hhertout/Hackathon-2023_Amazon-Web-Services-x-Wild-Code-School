<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, VehicleRepository $vehicleRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $carId = [];
            $energyArray = ['Diesel','Electric','Gasoline'];
            $brandArray = ['Peugeot','Citroën','Renault','Volkswagen','BMW','Mercedes','Hyundai','Audi','Opel','Toyota','Ford','Honda','DS',];
            $startDate = $form->getData()['startDate'];
            $endDate = $form->getData()['endDate'];

            $vehicles = $vehicleRepository->findAll();
            foreach($vehicles as $vehicle){
                $vehicleRent = $vehicle->getReservations();
                foreach($vehicleRent as $rent){
                    $vehiculeRentDateStart = $rent->getRentedDate();
                    $vehiculeRentDateEnd = $rent->getReturnDate();
                    //dd(($endDate > $vehiculeRentDateEnd && $endDate > $vehiculeRentDateEnd), $vehiculeRentDateStart, $vehiculeRentDateEnd);

                    if (!($startDate <= $vehiculeRentDateEnd && $endDate >= $vehiculeRentDateStart))
                    {
                        $carId[] = $rent->getVehicle()->getId();
                    }
                }
            }
            $brand = $form->getData()['Brand'];
            $energy = $form->getData()['energy'];
            
            return $this->render('home/index.html.twig', [
                'searchForm' => $form->createView(),
                'vehicles' => $vehicleRepository->findBy([
                    'id' => $carId,
                    'company' => $user->getCompany(),
                    'isAvailable' => true,
                    'brand' => $brand ?? $brandArray,
                    'energy' => $energy ?? $energyArray,
                ])
            ]);
        }

        return $this->render('home/index.html.twig', [
            'searchForm' => $form->createView(),
            'controller_name' => 'HomeController',
            'vehicles' => $vehicleRepository->findBy(['company' => $user->getCompany(), 'isAvailable' => true,])
        ]);
    }
}
