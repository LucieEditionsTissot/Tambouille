<?php

namespace App\Controller;


use App\Entity\Group;
use App\Form\GroupFormType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group_')]
class GroupController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function addGroup(Request $request): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupFormType::class, $group);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            return $this->redirectToRoute('group_list');
        }

        return $this->render('group/formGroup.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }
    #[Route('/list', name: 'list')]
    public function list(GroupRepository $groupRepository, EntityManagerInterface $entityManager):Response {

        $groupRepository = $entityManager->getRepository(Group::class);

        $groupList = $groupRepository->findAll();


        return $this->render('group/listGroup.html.twig', [
            dump($groupList)
        ]);
    }
}