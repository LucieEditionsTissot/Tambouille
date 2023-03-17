<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Entity\Ingredient;
use App\Entity\PreparationStep;
use App\Entity\Recipe;
use App\Entity\RecipeType;
use App\Entity\User;
use App\Transformer\EquipementTransformer;
use App\Transformer\RecipeTypeTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('nbPersons', IntegerType::class)
            ->add('author')
            ->add('ingredients', CollectionType::class, [
                'entry_type' => IngredientFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Ingrédients',
                'prototype' => '{{ form_widget(form.prototype) }}',
                'prototype_data' => new Ingredient(),
            ])
            ->add('steps', CollectionType::class, [
                'entry_type' => PreparationStepType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Étapes de préparation',
                'prototype' => '{{ form_widget(form.prototype) }}',
                'prototype_data' => new PreparationStep(),
            ])
            ->add('equipements', CollectionType::class, [
                'entry_type' => EquipementFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'label' => 'Équipements',
                'prototype' => '{{ form_widget(form.prototype) }}',
                'prototype_data' => new Equipement(),
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }

}