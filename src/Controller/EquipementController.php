<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Form\EquipementFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipementController extends AbstractController
{
    #[Route('/newEquipement', name: 'add_equipement')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipement();
        $form = $this->createForm(EquipementFormType::class, $equipement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();

            $recipe = $entityManager->getRepository(Recipe::class)->find($id);
            return $this->redirectToRoute('recipe_edit', ['id' => $recipe->getId()]);
        }

        return $this->render('equipement/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/equipement/{id}', name: 'delete_equipement')]
    public function delete(Request $request, Equipement $equipement,  EntityManagerInterface $entityManager, int $id): Response
    {

        $entityManager->getRepository(Equipement::class)->find($id);
        $entityManager->remove($equipement);
        $entityManager->flush();
        return $this->redirectToRoute('recipe_add', ['id' => $equipement->getRecipes()]);

    }


}