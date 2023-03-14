<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(Request $request,EntityManagerInterface $entityManager, #[CurrentUser] ?User $user): Response
    {
        $session = $request->getSession();
        $group = $session->get('group');

        return $this->render('feed/index.html.twig', [
            'hasGroup'=>$user->hasAtLeastOneGroup() and isset($group),
            "group"=>$group,
        ]);
    }
}
