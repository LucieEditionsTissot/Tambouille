<?php

namespace App\Controller;


use App\Entity\Group;
use App\Form\GroupFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group_')]
class GroupController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function addGroup(): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupFormType::class, $group);

        return $this->render('group/formGroup.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }
}