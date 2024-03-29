<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Form\IngredientFormType;

use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/newIngredient', name: 'add_ingredient')]
    public function addIngredient(Request $request, EntityManagerInterface $entityManager): Response
    {

        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientFormType::class, $ingredient);
        $form->handleRequest($request);

        $recipe = $request->query->get('recipes');
        $recipeObj = $entityManager->getRepository(Recipe::class)->find($recipe);
        $recipeId =$recipeObj->getIngredients();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->getRepository(Ingredient::class);
            $recipeObj->addIngredient($ingredient);
            $ingredient->addRecipe($recipeObj);
            $entityManager->persist($ingredient);
            $entityManager->persist($recipeObj);
            $entityManager->flush();
            return $this->redirectToRoute('recipe_edit', ['id' => $recipeObj->getId()]);

        }
        return $this->render('ingredient/ingredientForm.html.twig', [

            'form' => $form->createView(),
        ]);
    }

    #[Route('/ingredient/{id}', name: 'delete_ingredient')]
    public function delete(Request $request, Ingredient $ingredient,  EntityManagerInterface $entityManager, int $id): Response
    {

        $entityManager->getRepository(Ingredient::class)->find($id);
        $entityManager->remove($ingredient);
        $entityManager->flush();
        return $this->redirectToRoute('recipe_edit', ['id' => $ingredient->getRecipes()]);

    }

}