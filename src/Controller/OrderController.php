<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('order/index.html.twig', ['orders' => $orders]);
    }
    #[Route('/order/{id}', name: 'app_order_show',requirements: ['id' => '\d+'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', ['order' => $order]);
    }
}
