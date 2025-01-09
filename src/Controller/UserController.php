<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route(path: '/user', name: 'app_user')] // User connection page route
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/user/{id}', name: 'app_user_show', requirements: ['id' => '\d+'])] // User account page route
    public function show(): Response
    {
        return $this->render('user/show.html.twig');
    }

    #[Route('/user/register', name: 'app_user_register')] // User register page route
    public function register(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/register.html.twig');
    }

    #[Route('/user/{id}/update', name: 'app_user_update', requirements: ['id' => '\d+'])] // User updating account page route
    public function update(EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('user/update.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
