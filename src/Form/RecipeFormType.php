<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Ingredient;
use App\Entity\PreparationStep;
use App\Entity\Recipe;
use App\Entity\RecipeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\File;

class RecipeFormType extends AbstractType
{
    private Security $security;
    private ?UserInterface $user;
    private EntityManagerInterface $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->user = $this->security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('cookingTime', IntegerType::class)
            ->add('image', FileType::class, [
                'label' => 'Image',

                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'extensions' => 'png'
                    ])
                ],
            ])
            ->add('recipeType', EntityType::class, [
                'class' => RecipeType::class,
                'choice_label' => 'name',
            ])
            ->add('author')
            ->add('nbPersons', IntegerType::class)

            ->add('equipements', CollectionType::class, [
                'entry_type' => EquipementFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__ingredient_name__',
            ])
            ->add('ingredients', CollectionType::class, [
                'entry_type' => IngredientFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__ingredient_name__',
            ])
            ->add('ingredientQuantity', TextType::class)
            ->add('ingredientVolume', TextType::class)
            ->add('preparationStep', CollectionType::class, [
                'entry_type' => PreparationStepType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__ingredient_name__',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }

}