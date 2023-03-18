<?php

namespace App\Controller;

use App\Data\SearchRecipeData;
use App\Entity\Recipe;
use App\Form\SearchRecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use const App\Entity\GROUP_ID;

class CookingBookController extends AbstractController
{
    #[Route('/book', name: 'app_cooking_book')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchData = new SearchRecipeData();
        $form = $this->createForm(SearchRecipeType::class, $searchData);
        $session = $request->getSession();
        $groupId = $session->get('groupId');

        $recipes = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $recipes = $entityManager
                ->getRepository(Recipe::class)
                ->findSearchResult($searchData);
        } else {
            $recipes = $this->getRecipesbyGroupId($entityManager, $groupId);
        }
        return $this->render('cooking_book/index.html.twig', [
            'form' => $form->createView(),
            'recipes' => $recipes,
        ]);
    }

    private function getRecipesbyGroupId(EntityManagerInterface $entityManager, string $id) : array{
        return $entityManager->getRepository(Recipe::class)->findBy(
            array('groupId'=>$id)
        );
    }

}
