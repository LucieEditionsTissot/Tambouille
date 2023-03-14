<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RecipeFormType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('', name: 'recipe_')]
class RecipeController extends AbstractController
{
    #[Route('', name: 'list')]
    public function index(): Response
    {
        return $this->render('recipe/recipeForm.html.twig', [
            'recipeForm' => 'RecipeController',
        ]);
    }
    #[Route('/recipe/add', name: 'add')]
    public function addRecipe(Request $request, EntityManagerInterface
    $entityManager, UserRepository $userRepository) :Response {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($user instanceof User) {
            $recipe->setAuthor($user);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->getRepository(Recipe::class);

            $images = $form->get('image')->getData();
            foreach ($images as $imageFile) {
                $image = new Image();
                $image->setFilename($imageFile);
                $image->setRecipe($recipe);
                $recipe->addImage($image);
                $entityManager->persist($image);
            }
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_list');
        }

        return $this->render('recipe/recipeForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
