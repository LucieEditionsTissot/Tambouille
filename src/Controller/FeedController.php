<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostFromType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\String\Slugger\SluggerInterface;
use const App\Entity\GROUP_ID;

class FeedController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(Request $request,EntityManagerInterface $entityManager, #[CurrentUser] ?User $user): Response
    {
       // $session = $request->getSession();
        $group = null;
        $posts = null;
        if ($user->hasAtLeastOneGroup()) {
            //$groupId = $session->get(GROUP_ID);

            //if (!$groupId) {
                //$group = $this->selectFirstGroup($user, $session);
                //} else {
                //$group = $this->getGroupById($entityManager, $groupId);

            //}
            $groups= $user->getGroups();
            $group = $groups[0];

            $posts = $this->findPosts($entityManager, $group);
        }
//        dd($posts[0]->getComments()->getValues());
        return $this->render('feed/index.html.twig', [
            'hasGroup'=>$user->hasAtLeastOneGroup() and isset($group),
            "group"=>$group,
            "posts"=>$posts
        ]);
    }

    private function selectFirstGroup(User $user, SessionInterface $session){
        if ($user->hasAtLeastOneGroup()) {
            $first = $user->getGroups()[0];
            $session->set(GROUP_ID, $first->getId());
            return $first;
        }
        else null;
    }

    private function getGroupById(EntityManagerInterface $entityManager, string $id){
        return $entityManager->getRepository(Group::class)->findOneBy(
            array('id'=>$id)
        );
    }

    // recupères les posts de tout les users du current group
    private function findPosts(EntityManagerInterface $entityManager, Group $group): array
    {
        $posts = $entityManager->getRepository(Post::class)->findBy(
            array('groupId'=>$group->getId(), 'parent'=>null),
            array('createdAt' => 'DESC')
        );

        return $posts;
    }

    #[Route('/feed/publish', name: 'publish_post')]
    public function publish(Request $request,EntityManagerInterface $entityManager, #[CurrentUser] ?User $user, SluggerInterface $slugger): Response
    {
        $post = new Post();
        $groupId = $request->getSession()->get(GROUP_ID);
        $group = $this->getGroupById($entityManager, $groupId);
        $post->setGroupId($group);
        $form = $this->createForm(PostFromType::class, $post);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $post = $form->getData();
            $post->setAuthor($user);

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $post->setImage($newFilename);
                $entityManager->persist($post);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_feed');
        }


        return $this->render('feed/publish/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
