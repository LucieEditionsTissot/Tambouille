<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Recipe;
use App\Form\RecipeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recipe', name: 'recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(): Response
    {
        return $this->render('recipe/recipeForm.html.twig', [
            'recipeForm' => 'RecipeController',
        ]);
    }
    #[Route('/add', name: 'add')]
    public function addRecipe(Request $request) :Response {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $recipe->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();

            $recipe = $form->getData();
            $images = $form->get('images')->getData();
            foreach ($images as $imageFile) {
                $image = new Image();
                $image->setFilename($imageFile);
                $image->setRecipe($recipe);
                $recipe->addImage($image);
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
