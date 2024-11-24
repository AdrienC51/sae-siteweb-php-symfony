<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')] //User connection page route
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
    #[Route('/user/{id}', name: 'app_user_show', requirements: ['id' => '\d+'])] //User account page route
    public function show(): Response
    {
        return $this->render('user/show.html.twig');
    }
    #[Route('/user/register', name: 'app_user_register')] //User register page route
    public function register(EntityManagerInterface $entityManager,Request $request): Response
    {
        return $this->render('user/register.html.twig');
    }


    #[Route('/user/{id}/update', name: 'app_user_update', requirements: ['id' => '\d+'])] //User updating account page route
    public function update(EntityManagerInterface $entityManager,Request $request): Response
    {
        return $this->render('user/update.html.twig');
    }
}
