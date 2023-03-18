<?php

namespace App\Form;

use App\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'=> ['class'=> 'form-input-style'],
                'label' => 'Nom de groupe'
            ])
            ->add('code', TextType::class, array(
                'disabled' => true,
                'attr'=> [
                    'style' => 'width: fit-content',
                    'class' => 'form-input-style'
                    ],
                'label' => 'Code groupe'
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }

}