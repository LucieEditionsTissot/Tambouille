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
    #[Route('/recipe/{recipeId}/reviews/add', name: 'add_review')]
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


}
