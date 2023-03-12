<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\RecipeType;
use App\Form\GroupFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipeForm' => 'RecipeController',
        ]);
    }

    public function addRecipe(Request $request) :Response {
        $recipe = new Recipe();
        $form = $this->createForm(Recipe::class, $recipe);
        $form->handleRequest($request);

        return $this->render('recipe/index.html.twig', [
            'recipeForm' => $form->createView(),
        ]);
    }
}
