<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\PreparationStep;
use App\Entity\Recipe;
use App\Form\PreparationStepType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreparationStepController extends AbstractController
{
    #[Route('/newPreparationStep', name: 'add_preparationStep')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $preparationStep = new PreparationStep();
        $form = $this->createForm(PreparationStepType::class, $preparationStep);
        $form->handleRequest($request);
        $recipe = $request->query->get('recipe');

        if ($recipe) {
            $recipeObj = $entityManager->getRepository(Recipe::class)->find($recipe);
            $last = $recipeObj->getPreparationStep();
            $preparationStep->setOrdre($last->last()->getOrdre());
        } else {
            $preparationStep->setOrdre(1);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($preparationStep);
            $entityManager->flush();
            if ($recipe) {
                $recipeObj = $entityManager->getRepository(Recipe::class)->find($recipe);
                $recipeObj->addPreparationStep($preparationStep);
                $preparationStep->addRecipe($recipeObj);
                $entityManager->persist($preparationStep);
                $entityManager->persist($recipeObj);
                $entityManager->flush();
                $this->addFlash('success', 'Étape de préparation ajoutée avec succès.');

                return $this->redirectToRoute('recipe_edit', ['id' => $recipeObj->getId()]);
            }
            else {
                return $this->redirectToRoute('recipe_add', ['step' => $preparationStep->getId()]);
            }

        }

        return $this->render('preparationStep/preparationStepForm.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter une étape de préparation'
        ]);
    }
    #[Route('/preparationStep/{id}', name: 'delete_preparationStep')]
    public function delete(Request $request, PreparationStep $preparationStep,  EntityManagerInterface $entityManager, int $id): Response
    {

        $entityManager->getRepository(PreparationStep::class)->find($id);
        $entityManager->remove($preparationStep);
        $entityManager->flush();
        return $this->redirectToRoute('recipe_add', ['id' => $preparationStep->getRecipe()]);

    }

}