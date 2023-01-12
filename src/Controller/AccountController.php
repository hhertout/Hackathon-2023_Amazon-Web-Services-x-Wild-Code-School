<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\VehicleRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/my-account', name: 'app_account')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        /** @var User $user  */
        $user = $this->getUser();
        $userId = $user->getId();

        $reservation = $reservationRepository->findBy(['user' => $userId], [], [1]);

        return $this->render('account/index.html.twig', [
            'reservation' => $reservation[0] ?? null
        ]);
    }

    #[Route('/my-reservation', name: 'app_reservation')]
    public function showReservation(ReservationRepository $reservationRepository): Response
    {
        /** @var User $user  */
        $user = $this->getUser();
        $userId = $user->getId();

        $reservations = $reservationRepository->findBy(['user' => $userId]);

        return $this->render('account/showReservation.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/my-infos', name: 'app_account_info')]
    public function showMyInfo(): Response
    {
        return $this->render('account/personnalInfo.html.twig');
    }

    #[Route('/my-reservation/{id}', name: 'app_reservation_id')]
    public function showReservationById(VehicleRepository $vehicleRepository, Reservation $reservation): Response
    {
        /** @var User $user  */
        $user = $this->getUser();
        $userId = $user->getId();
        $vehicleId = $reservation->getVehicle()->getId();
        $vehicle = $vehicleRepository->findOneBy(['id' => $vehicleId]);

        dump($vehicle);
        return $this->render('account/showReservationId.html.twig', [
            'reservation' => $reservation,
            'vehicle' => $vehicle
        ]);
    }
}
