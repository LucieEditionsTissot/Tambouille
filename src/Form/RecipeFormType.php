<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Group;
use App\Entity\RecipeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeFormType
{

    private EntityManagerInterface $entityManager;

    public function buildForm(Request $request, FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('cookingTime', IntegerType::class)
            ->add('images', FileType::class)
            ->add('nbPersons', IntegerType::class)
            ->add('author', ChoiceType::class, [
                'choices' => $this->getUser()->getAuthors(),
                'choice_label' => function($author) {
                    return $author->getFullName();
                },
                'choice_value' => function($author) {
                    return $author->getId();
                },
            ])
            ->add('user_id', HiddenType::class, [
                'users' => $this->getUser()->getId(),
            ])
            ->add('recipeType', IntegerType::class)
            ->add('equipementsType', ChoiceType::class, [
                'choices' => $this->getEquipementsChoices(),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('recipeType', RecipeType::class);

    }
    private function getEquipementsChoices(): array
    {
        $equipements = $this->entityManager->getRepository(Equipement::class)->findAll();
        $choices = [];
        foreach ($equipements as $equipement) {
            $choices[$equipement->getName()] = $equipement->getId();
        }
        return $choices;
    }


}