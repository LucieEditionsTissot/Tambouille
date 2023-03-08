<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group_')]
class GroupController
{
    #[Route('/add', name: 'add')]
    public function index(): Response
    {
        return $this->render('group/formGroup.html.twig', [
            'controller_name' => 'GroupController',
        ]);
    }
}