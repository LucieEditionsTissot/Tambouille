<?php

namespace App\DataFixtures;

use App\Entity\RecipeType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $recipeType1 = new RecipeType();
        $recipeType1->setName('Entrée');

        $recipeType2 = new RecipeType();
        $recipeType2->setName('Plat');

        $recipeType3 = new RecipeType();
        $recipeType3->setName('Dessert');

        $recipeType4 = new RecipeType();
        $recipeType4->setName('Apéro');

        $manager->persist($recipeType1);
        $manager->persist($recipeType2);
        $manager->persist($recipeType3);
        $manager->persist($recipeType4);

        $manager->flush();
    }
}