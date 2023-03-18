<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ingredient1 = new Ingredient();
        $ingredient1->setName('Pommes de terre');

        $ingredient2 = new Ingredient();
        $ingredient2->setName('Oignons');

        $ingredient3 = new Ingredient();
        $ingredient3->setName('Carottes');

        $ingredient4 = new Ingredient();
        $ingredient4->setName('Poulet');

        $ingredient5 = new Ingredient();
        $ingredient5->setName('Fenouil');

        $manager->persist($ingredient1);
        $manager->persist($ingredient2);
        $manager->persist($ingredient3);
        $manager->persist($ingredient4);
        $manager->persist($ingredient5);

        $manager->flush();
    }
}