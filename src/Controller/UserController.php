<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function index(#[CurrentUser] ?User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user'=>$user
        ]);
    }
}
