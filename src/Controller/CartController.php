<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CartLine;
use App\Repository\CartLineRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class CartController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/cart', name: 'app_cart_list')]
    public function listClients(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();

        return $this->render('cart/list.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function removeFromCart(
        CartLine $cartLine,
        EntityManagerInterface $entityManager,
    ): Response {
        $clientId = $cartLine->getClient()->getId();
        $entityManager->remove($cartLine);
        $entityManager->flush();

        return $this->redirectToRoute('app_cart', ['clientId' => $clientId]);
    }

    #[Route('/cart/{clientId}', name: 'app_cart', requirements: ['clientId' => '\d+'])]
    public function indexid(int $clientId, CartLineRepository $cartLineRepository, ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find($clientId);

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        $cartLines = $cartLineRepository->findBy(['client' => $client]);

        $total = 0;
        foreach ($cartLines as $line) {
            $total += $line->getQuantity() * $line->getArticle()->getPrice();
        }

        return $this->render('cart/index.html.twig', [
            'cartLines' => $cartLines,
            'total' => $total,
            'client' => $client,
        ]);
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function updateQuantity(
        int $id,
        CartLineRepository $cartLineRepository,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        dump($id);

        $cartLine = $cartLineRepository->find($id);
        dump($cartLine);

        if (!$cartLine) {
            throw $this->createNotFoundException('Ligne de panier non trouvée (ID: '.$id.')');
        }

        $quantity = (int) $request->request->get('quantity');

        if ($quantity > 0) {
            $cartLine->setQuantity($quantity);
            $entityManager->persist($cartLine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cart', [
            'clientId' => $cartLine->getClient()->getId(),
        ]);
    }

    #[Route('/cart/{clientId}/order', name: 'app_order_create', requirements: ['clientId' => '\d+'])]
    public function createOrder(
        int $clientId,
        ClientRepository $clientRepository,
    ): Response {
        $client = $clientRepository->find($clientId);

        if (!$client) {
            throw $this->createNotFoundException('Client non trouvé');
        }

        $this->addFlash('error', 'La création de commande n\'est pas encore implémentée');

        return $this->redirectToRoute('app_cart', ['clientId' => $clientId]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', requirements: ['id' => '\d+'])]
    public function addToCart(Article $article, EntityManagerInterface $entityManager)
    {
        if (null !== $this->getUser()->getClient()) {
            $cartLine = new CartLine();
            $cartLine->setClient($this->getUser()->getClient());
            $cartLine->setArticle($article);
            $cartLine->setQuantity(1);
            $entityManager->persist($cartLine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_shop');
    }
}
