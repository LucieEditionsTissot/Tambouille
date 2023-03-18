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
                'attr'=> ['style'=> 'background-color: rgba(229,221, 205,50%); border: none'],
                'label' => 'Nom de groupe'
            ])
            ->add('code', TextType::class, array(
                'disabled' => true,
                'attr'=> [
                    'style'=> 'background-color: rgba(229,221, 205,50%); border: none; width: fit-content',
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