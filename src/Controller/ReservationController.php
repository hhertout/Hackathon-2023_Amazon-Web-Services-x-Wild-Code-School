<?php

namespace App\Controller;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{vehicle}', name: 'app_reservation')]
    public function index(Request $request, VehicleRepository $vehicleRepository, Vehicle $vehicle): Response
    {
        return $this->render('reservation/index.html.twig', [
            'vehicle' => $vehicleRepository->findOneBy(['id' => $vehicle]),
        ]);
    }
}
