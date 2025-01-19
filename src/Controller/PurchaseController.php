<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[\Symfony\Component\Routing\Annotation\Route('/purchase/confirm', name: 'app_purchase_confirm', methods: ['POST'])]
    public function confirm(Request $request): Response
    {
        $cardNumber = $request->request->get('cardNumber');
        $expiryDate = $request->request->get('expiryDate');
        $cvv = $request->request->get('cvv');
        $cardHolder = $request->request->get('cardHolder');

        if (empty($cardNumber) || empty($expiryDate) || empty($cvv) || empty($cardHolder)) {
            $this->addFlash('error', 'All fields must be completed.');

            return $this->redirectToRoute('app_purchase');
        }

        return $this->redirectToRoute('app_purchase_success');
    }

    #[Route('/purchase/success', name: 'app_purchase_success')]
    public function success(): Response
    {
        return $this->render('purchase/success.html.twig', [
            'message' => 'Your purchase was successful!',
        ]);
    }
}
