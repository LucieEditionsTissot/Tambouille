<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    #[Route('/profile/edit', name: 'app_user_edit')]
    public function edit(Request $request,  UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $fileName = md5(uniqid()) . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    throw new \Exception('Une erreur est survenue lors de l\'upload de l\'image.');
                }

                $user->setImage($fileName);
            }

            $password = $form->get('password')->getData();
            if ($password) {
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le profil a été mis à jour.');

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
