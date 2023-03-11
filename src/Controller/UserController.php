<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(Security $security)
    {

        $user = $security->getUser();

        if ($user) {
            $username = $user->getUsername();
            $email = $user->getEmail();

            return $this->render('user/index.html.twig', [
                'username' => $username,
                'email' => $email,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}