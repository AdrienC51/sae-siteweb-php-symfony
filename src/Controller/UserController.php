<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }
    #[Route('/user/{id}', name: 'app_user_show', requirements: ['id' => '\d+'])]
    public function show(): Response
    {
        return $this->render('user/show.html.twig');
    }
    #[Route('/user/register', name: 'app_user_register')]
    public function register(EntityManagerInterface $entityManager,Request $request): Response
    {
        return $this->render('user/register.html.twig');
    }

}
