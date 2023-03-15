<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Image;
use App\Entity\Recipe;
use App\Entity\User;
use App\Form\RecipeFormType;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function PHPUnit\Framework\throwException;
use const App\Entity\GROUP_ID;

#[Route('/recipe', name: 'recipe_')]
class RecipeController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(Request $request,EntityManagerInterface $entityManager, ?User $user): Response
    {
        $session = $request->getSession();
        $groupId = $session->get(GROUP_ID);
        if(!$groupId){

        }else{
            $group = $this->getGroupById($entityManager, $groupId);
        }

        $recipe = $this->find($entityManager, $group);
        return $this->render('recipe/listRecipe.html.twig', [
            'hasGroup'=>$user->hasAtLeastOneGroup() and isset($group),
            "group"=>$group,
            "recipes"=>$recipe
        ]);
    }


    private function getGroupById(EntityManagerInterface $entityManager, string $id){
        return $entityManager->getRepository(Group::class)->findOneBy(
            array('id'=>$id)
        );
    }

    #[Route('/add', name: 'add')]
    public function addRecipe(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {

        $recipe = new Recipe();
        $groupId = $request->getSession()->get(GROUP_ID);
        $group = $this->getGroupById($entityManager, $groupId);
        $recipe->setGroupId($group);
        $user = $this->getUser();
        if ($user instanceof User) {
            $recipe->setAuthor($user);
        }
        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->getRepository(Recipe::class);
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $images = [$newFilename]; // Wrap the newFilename in an array
                $recipe->setImages($images);
            }
            $entityManager->persist($recipe);
            dump($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_list');
        }
        return $this->render('recipe/recipeForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}/edit', name: 'edit')]
    public function editRecipe(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, int $id): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }

        $form = $this->createForm(RecipeFormType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $images = [$newFilename]; // Wrap the newFilename in an array
                $recipe->setImages($images);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_cooking_book');
        }

        return $this->render('recipe/recipeForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/show', name: 'show')]
    public function showRecipe(Recipe $recipes): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function deleteRecipe(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException('Nous n\'avons pas trouvé cette recette');
        }

        $entityManager->remove($recipe);
        $entityManager->flush();

        $this->addFlash('success', 'Votre recette a bien été supprimé');

        return $this->redirectToRoute('app_cooking_book');
    }
}


