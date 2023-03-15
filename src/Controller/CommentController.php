<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use const App\Entity\GROUP_ID;

class CommentController extends AbstractController
{
    #[Route('/comment/add', name: 'add_comment')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $content = $request->request->get('content');
        $postId = $request->request->get('postId');
        $parent = $this->getPostById($entityManager, $postId);
        $groupId = $request->getSession()->get(GROUP_ID);
        $group = $this->getGroupById($entityManager, $groupId);

        $comment = new Post();
        $comment->setAuthor($this->getUser())->setGroupId($group)->setContent($content)->setRecipe($parent->getRecipe());

        $parent->addComment($comment);
        $entityManager->persist($comment);
        $entityManager->persist($parent);
        $entityManager->flush();

        return $this->redirectToRoute('app_feed');
    }


    private function getGroupById(EntityManagerInterface $entityManager, string $id){
        return $entityManager->getRepository(Group::class)->findOneBy(
            array('id'=>$id)
        );
    }
    private function getPostById(EntityManagerInterface $entityManager, string $id){
        return $entityManager->getRepository(Post::class)->findOneBy(
            array('id'=>$id)
        );
    }

    #[Route('/comment/delete', name: 'delete_comment')]
    public function delete(EntityManagerInterface $entityManager, Request $request): Response
    {



//        $entityManager->persist($parent);
//        $entityManager->flush();

        return $this->redirectToRoute('app_feed');
    }


}