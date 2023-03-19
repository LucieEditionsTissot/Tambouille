<?php

namespace App\Form;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => 'Nom de l\'ingrédient',
            ])
            ->add('ingredientQuantity', IntegerType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('ingredientVolume', ChoiceType::class, [
                'label' => 'Volume',
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'ml' => 'ml',
                    'cl' => 'cl',
                    'dl' => 'dl',
                    'l' => 'l',
                    'g' => 'g',
                    'kg' => 'kg'
                ]
            ])
            ->add('recipe', HiddenType::class, [
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}