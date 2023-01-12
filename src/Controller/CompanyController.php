<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompanyController extends AbstractController
{
    #[Route('/dashboard', name: 'app_company_home')]
    public function index(Request $request): Response
    {


        return $this->render('company/index.html.twig', []);
    }
}
