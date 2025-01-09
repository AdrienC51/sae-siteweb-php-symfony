<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'app_user_show', requirements: ['id' => '\d+'])] // User account page route
    public function show(Account $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/register', name: 'app_user_register')] // User register page route
    public function register(EntityManagerInterface $entityManager, Request $request): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', ['id' => $account->getId()]);
        }

        return $this->render('user/register.html.twig', [
            'account' => $account,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}/update', name: 'app_user_update', requirements: ['id' => '\d+'])] // User updating account page route
    public function update(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/update.html.twig');
    }
}
