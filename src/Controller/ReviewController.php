<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Entity\Review;
use App\Entity\User;
use App\Form\ReviewFormType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    #[Route('/recipe/{recipeId}/reviews/add', name: 'review_add')]
    public function addReview(Request $request, EntityManagerInterface $entityManager, int $recipeId): Response
    {

        $recipe = $entityManager->getRepository(Recipe::class)->find($recipeId);

        $user = $this->getUser();
        $review = new Review();
        if ($user instanceof User) {
            $review->setAuthor($user);
        }
        $review->setRecipe($recipe);


        $review->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $recipeId]);
        }

        return $this->render('review/reviewForm.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipe/review/{id}/edit', name: 'review_edit')]
    public function editReview(Request $request, EntityManagerInterface $entityManager, Review $review): Response
    {
        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('recipe_show', ['id' => $review->getRecipe()->getId()]);
        }

        return $this->render('review/reviewForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/recipe/review/{id}/delete', name: 'review_delete')]
    public function deleteReview(EntityManagerInterface $entityManager, Review $review): Response
    {
        $recipeId = $review->getRecipe()->getId();

        $entityManager->remove($review);
        $entityManager->flush();

        return $this->redirectToRoute('recipe_show', ['id' => $recipeId]);
    }

}
