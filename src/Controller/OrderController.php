<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderLine;
use App\Entity\StockEvolution;
use App\Repository\CartLineRepository;
use App\Repository\ClientRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class OrderController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAllOrderedByNewestDate();

        return $this->render('order/index.html.twig', ['orders' => $orders]);
    }
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/order/{id}', name: 'app_order_show', requirements: ['id' => '\d+'])]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', ['order' => $order]);
    }

    #[Route('/order/create/{clientId}', name: 'app_order_create')]
    public function create(
        int $clientId,
        ClientRepository $clientRepository,
        CartLineRepository $cartLineRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $client = $clientRepository->find($clientId);

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        $cartLines = $cartLineRepository->findBy(['client' => $client]);
        foreach ($cartLines as $cartLine) {
            $article = $cartLine->getArticle();
            $quantityRequested = $cartLine->getQuantity();
            $availableQuantity = $article->getAvailableQuantity();

            if ($quantityRequested > $availableQuantity) {
                $this->addFlash('error', sprintf(
                    'Stock insuffisant pour l\'article: %s (Quantité disponible: %d)',
                    $article->getName(),
                    $availableQuantity
                ));

                return $this->redirectToRoute('app_cart', ['clientId' => $clientId]);
            }
        }

        $order = new Order();
        $order->setOrderDate(new \DateTime());
        $order->setClient($client);
        $order->setStatus('Pending');
        $order->setDestAddress($client->getAddress());
        $order->setDestPostCode($client->getPostCode());
        $order->setDestCity($client->getCity());

        foreach ($cartLines as $cartLine) {
            $orderLine = new OrderLine();
            $orderLine->setArticle($cartLine->getArticle());
            $orderLine->setQuantity($cartLine->getQuantity());
            $orderLine->setRelatedOrder($order);

            $entityManager->persist($orderLine);
        }

        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_order_confirmation', ['orderId' => $order->getId()]);
    }

    #[Route('/order/confirmation/{orderId}', name: 'app_order_confirmation')]
    public function confirmation(
        int $orderId,
        OrderRepository $orderRepository,
    ): Response {
        $order = $orderRepository->find($orderId);

        if (!$order) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        $total = 0;
        foreach ($order->getOrderLines() as $line) {
            $total += $line->getQuantity() * $line->getArticle()->getPrice();
        }

        return $this->render('order/com.html.twig', [
            'order' => $order,
            'total' => $total,
        ]);
    }

    #[Route('/order/payment/{orderId}', name: 'app_order_payment')]
    public function payment(
        int $orderId,
        OrderRepository $orderRepository,
        CartLineRepository $cartLineRepository,
        EntityManagerInterface $entityManager,
    ): Response {
        $order = $orderRepository->find($orderId);

        if (!$order) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        $cartLines = $cartLineRepository->findBy(['client' => $order->getClient()]);

        foreach ($cartLines as $cartLine) {
            $stockEvolution = new StockEvolution();
            $stockEvolution->setArticle($cartLine->getArticle());
            $stockEvolution->setQuantity($cartLine->getQuantity());
            $stockEvolution->setType('OUT');
            $stockEvolution->setEvolutionDate(new \DateTime());

            $entityManager->persist($stockEvolution);
            $entityManager->remove($cartLine);
        }

        $order->setStatus('Accepted');

        $entityManager->flush();

        return $this->redirectToRoute('app_payment_success', ['orderId' => $order->getId()]);
    }

    #[Route('/order/payment/success/{orderId}', name: 'app_payment_success')]
    public function paymentSuccess(int $orderId, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($orderId);

        if (!$order) {
            throw $this->createNotFoundException('Commande non trouvée');
        }

        return $this->render('order/payment_success.html.twig', [
            'order' => $order,
        ]);
    }
}
