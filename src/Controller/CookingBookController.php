<?php

namespace App\Controller;

use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
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
        $session = $request->getSession();
        $groupId = $session->get('groupId');
        $recipes = $this->getRecipesbyGroupId($entityManager, $groupId);
        return $this->render('cooking_book/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    private function getRecipesbyGroupId(EntityManagerInterface $entityManager, string $id) : array{
        return $entityManager->getRepository(Recipe::class)->findBy(
            array('groupId'=>$id)
        );
    }



}
