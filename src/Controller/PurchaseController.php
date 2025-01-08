<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'app_purchase')]
    public function index(): Response
    {
        return $this->render('purchase/index.html.twig', [
            'controller_name' => 'PurchaseController',
        ]);
    }

    #[Route('/purchase/success', name: 'app_purchase_success')]
    public function success(): Response
    {
        return $this->render('purchase/success.html.twig', [
            'message' => 'Your purchase was successful!',
        ]);
    }
}

