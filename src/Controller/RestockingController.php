<?php

namespace App\Controller;

use App\Entity\Restocking;
use App\Repository\RestockingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestockingController extends AbstractController
{
    #[Route('/restocking', name: 'app_restocking')]
    public function index(RestockingRepository $restockingRepository): Response
    {
        $restocks = $restockingRepository->findAllOrderedByNewestDate();
        return $this->render('restocking/index.html.twig', ['restocks' => $restocks]);
    }
    #[Route('/restocking/{id}', name: 'app_restocking_show',requirements: ['id' => '\d+'])]
    public function show(Restocking $restocking): Response
    {
        return $this->render('restocking/show.html.twig', ['restocking' => $restocking]);
    }
}
