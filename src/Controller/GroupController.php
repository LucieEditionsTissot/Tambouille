<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Link;
use App\Entity\User;
use App\Form\GroupFormType;
use App\Form\JoinGroupFormType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use function PHPUnit\Framework\throwException;

class GroupController extends AbstractController
{
    #[Route('/group/create', name: 'create_group')]
    public function createIndex(Request $request, EntityManagerInterface $entityManager, #[CurrentUser] ?User $user): Response
    {

        $group = new Group();
        $form = $this->createForm(GroupFormType::class, $group);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $group = $form->getData();
            $this->saveGroup($entityManager, $group, $user);

            return $this->redirectToRoute('app_feed');
        }

        return $this->render('group/create/index.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }

    private function saveGroup(EntityManagerInterface $entityManager, Group $group, $user){
        if(!$user){
            throw new Exception('Need to be logged');
        }
        $group->addUser($user);
        $entityManager->persist($group);
        $entityManager->flush();
    }

    #[Route('/group/join', name: 'join_group')]
    public function joinIndex(Request $request, EntityManagerInterface $entityManager, #[CurrentUser] ?User $user): Response
    {
        $code = $request->request->get('code');
        if($code){
            $group = $this->findMatchingGroup($entityManager, $code);
            $this->saveGroup($entityManager, $group, $user);
            return $this->redirectToRoute('app_feed');
        }


        return $this->render('group/join/index.html.twig', [
        ]);
    }

    private function findMatchingGroup(EntityManagerInterface $entityManager, string $code) : Group | null{

        return $entityManager->getRepository(Group::class)->findOneBy(
            array('code'=>$code)
        );

    }
}
