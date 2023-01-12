<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/dashboard/{company}/')]
class CompanyController extends AbstractController
{
    #[Route('', name: 'app_company_home', methods: ['GET'])]
    public function index(Company $company, VehicleRepository $vehicleRepository): Response
    {
        return $this->render('company/fleet.html.twig', [
            
        ]);
    }
    #[Route('', name: 'app_company_fleet', methods: ['GET'])]
    public function fleet(Company $company, VehicleRepository $vehicleRepository): Response
    {
        return $this->render('company/fleet.html.twig', [
            'company' => $company
        ]);
    }

    #[Route('vehicle/new', name: 'app_vehicle_new', methods: ['GET', 'POST'])]
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

        return $this->redirectToRoute('app_company_home', ['company' => $vehicle->getCompany()->getId()], Response::HTTP_SEE_OTHER);
    }
}
