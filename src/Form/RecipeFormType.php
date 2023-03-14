<?php

namespace App\Form;

use App\Entity\Equipement;
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
                'mapped' => false,
                'label' => 'Images (JPG, PNG or GIF files)',
                'multiple' => true,
                'required' => false,
            ])
            ->add('recipeType')
            ->add('nbPersons', IntegerType::class)
            ->add('author')
            ->add('equipements')
            ->add('submit', SubmitType::class);
    }
    private function getEquipementsChoices(): array
    {
        return [
            'Mixeur' => 'Mixeur',
            'Batteur' => 'Batteur',
            'Four' => 'Four',
            'Drink' => 'Drink',
            'Salad' => 'Salad',
        ];
    }
    private function getRecipesTypeChoices(): array
    {
        return [
            'Dessert' => 'Dessert',
            'Main Course' => 'Main Course',
            'Appetizer' => 'Appetizer',
            'Drink' => 'Drink',
            'Salad' => 'Salad',
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }

}