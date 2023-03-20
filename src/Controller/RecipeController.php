<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Group;
use App\Entity\Image;
use App\Entity\Ingredient;
use App\Entity\IngredientQuantity;
use App\Entity\Post;
use App\Entity\PreparationStep;
use App\Entity\Recipe;
use App\Entity\User;
use App\Form\IngredientFormType;
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
use const App\Entity\POST_TYPE_NOTIFICATION;

#[Route('/recipe', name: 'recipe_')]
class RecipeController extends AbstractController
{
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
            $imageFile = $form->get('images')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $recipe->setImages($newFilename);
            }


            $newPost = $this->createPostToNotify($recipe);

            $entityManager->persist($recipe);
            $entityManager->persist($newPost);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_edit', ['id' => $recipe->getId()]);
        }
        return $this->render('recipe/recipeForm.html.twig', [
            'form' => $form->createView(),
            'recipe' => $recipe

        ]);
    }

    private function createPostToNotify(Recipe $recipe): Post
    {
        $post = new Post();
        $post->setRecipe($recipe)->setType(POST_TYPE_NOTIFICATION)->setAuthor($recipe->getAuthor())->setGroupId($recipe->getGroupId())->setContent('');
        if(isset($recipe->getImages()[0])){
            $post->setImage($recipe->getImages()[0]);
        }
        return $post;
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function editRecipe(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, int $id): Response
    {
        $recipe = $entityManager->getRepository(Recipe::class)->find($id);
        $ingredients = $recipe->getIngredients();
        $equipements = $recipe->getEquipements();
        $preparationSteps = $recipe->getPreparationStep();

        if (!$recipe) {
            throw $this->createNotFoundException('Recipe not found');
        }
        $newStep = $request->query->get('description');

        $newIngredientName = $request->query->get('name');
        $newIngredientQuantity = $request->query->get('ingredientQuantity');
        $newIngredientVolume = $request->query->get('ingredientVolume');

        if($newIngredientName && $newIngredientQuantity && $newIngredientVolume) {
            $ingredient = $entityManager->getRepository(Ingredient::class)->find($newIngredientName, $newIngredientQuantity, $newIngredientVolume);
            $ingredients->add($ingredient);
        }
        if ($newStep) {
            $step = $entityManager->getRepository(PreparationStep::class)->find($newStep);
            $preparationSteps->add($step);
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
                $recipe->setImages($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_cooking_book');
        }

        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
            'ingredients' => $ingredients,
            'equipements' => $equipements,
            'preparationSteps' => $preparationSteps,
            'recipe' => $recipe
        ]);
    }

    #[Route('/{id}/show', name: 'show')]
    public function showRecipe(Recipe $recipe, EntityManagerInterface $entityManager): Response
    {
        $reviews = $recipe->getReviews();
        $posts = $this->getPostsByRecipe($recipe);
        $ingredients = $this->getIngredientsQuantity($recipe, $entityManager);
        return $this->render('recipe/show.html.twig', [
            'recipes' => $recipe,
            'reviews' => $reviews,
            'posts' => $posts,
            'quantity' => $ingredients

        ]);
    }

    private function getPostsByRecipe(Recipe $recipe){
        $posts = $recipe->getPosts()->getValues();
        $posts = array_filter($posts, function($p) {
            return $p->getParent() == null;
        });
        return $posts;
    }
    private function getIngredientsQuantity(Recipe $recipe, EntityManagerInterface $entityManager){
        $quantity = $entityManager->getRepository(IngredientQuantity::class)->findBy(
            array('recipe' => $recipe)
        );
        return $quantity;
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

    #[Route('/new/ingredient', name: 'add_ingredient')]
    public function newIngredient(Request $request, EntityManagerInterface $entityManager)
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientFormType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->getRepository(Ingredient::class);
            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('recipe_add');
        }

        return $this->render('in/new_ingredient.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
