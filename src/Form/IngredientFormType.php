<?php

namespace App\Form;
use App\Entity\Ingredient;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'ingrédient',
            ])
            ->add('ingredientType', TextType::class, [
                'label' => 'Type d\'ingrédient',
            ])
            ->add('ingredientQuantity', IntegerType::class, [
                'label' => 'Quantité d\'ingrédient',
            ])
            ->add('ingredientVolume', TextType::class, [
                'label' => 'Volume d\'ingrédient',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}