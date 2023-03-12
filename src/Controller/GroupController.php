<?php

namespace App\Controller;


use App\Entity\Group;
use App\Form\GroupFormType;
use App\Repository\GroupRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/group', name: 'group_')]
class GroupController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function addGroup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupFormType::class, $group);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $users = $form->get('users')->getData();

            foreach ($users as $user) {
                $group->addUser($user);
            }

            $entityManager->persist($group);
            $entityManager->flush();

            $task = $form->getData();
            return $this->redirectToRoute('group_list');
        }

        return $this->render('group/formGroup.html.twig', [
            'users' => $form->get('users')->getData(),
            'groupForm' => $form->createView(),
        ]);
    }
    #[Route('/list', name: 'list')]
    public function list(GroupRepository $groupRepository, EntityManagerInterface $entityManager, Security $security):Response {

        $groupRepository = $entityManager->getRepository(Group::class);

        $security->getUser();
        $groupList = $groupRepository->findAll();
        $groupUsers = array();

        foreach($groupList as $group) {
            $users = $group->getUsers();
            $groupUsers[] = array(
                'group' => $group,
                'users' => $users
            );
        }

        return $this->render('group/listGroup.html.twig', [
            'groupUsers' => $groupUsers
        ]);
    }
}