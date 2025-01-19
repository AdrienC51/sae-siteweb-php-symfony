<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Client;
use App\Form\AccountType;
use App\Form\ClientType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

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
    public function register(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();
            $password = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($account, $password);
            $account->setPassword($hashedPassword);
            $client = new Client();
            $client->setAddress(' ');
            $client->setPhone(' ');
            $client->setCity(' ');
            $client->setPostCode(' ');
            $entityManager->persist($client);
            $account->setClient($client);
            $entityManager->persist($account);
            $entityManager->flush();
            $userAuthenticator->authenticateUser($account, $authenticator, $request);

            return $this->redirectToRoute('app_user_update_client', ['id' => $account->getId()]);
        }

        return $this->render('user/register.html.twig', [
            'account' => $account,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}/update', name: 'app_user_update', requirements: ['id' => '\d+'])] // User updating account page route
    public function update(Account $account, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($account, $password);
            $account->setPassword($hashedPassword);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', ['id' => $account->getId()]);
        }

        return $this->render('user/update.html.twig', [
            'account' => $account,
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}/updateClient', name: 'app_user_update_client', requirements: ['id' => '\d+'])] // User updating account page route
    public function updateClient(Account $account, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if (null !== $account->getClient()) {
            $form = $this->createForm(ClientType::class, $account->getClient());
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_user_show', ['id' => $account->getId()]);
            }

            return $this->render('user/updateClient.html.twig', [
                'account' => $account,
                'form' => $form,
            ]);
        }

        return $this->redirectToRoute('app_user_show', ['id' => $account->getId()]);
    }
}
