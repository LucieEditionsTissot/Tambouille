<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{
    #[Route('/modal', name: 'ingredient_create_modal')]
    public function createModal(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientFormType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->getRepository(Ingredient::class);
            $entityManager->persist($ingredient);
            $entityManager->flush();

            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_add');
        }
        return $this->render('recipe/recipeForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
