<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public const INGREDIENT_REFERENCE = 'ingredient1';
    public const INGREDIENT2_REFERENCE = 'ingredient2';
    public const INGREDIENT3_REFERENCE = 'ingredient3';
    public const INGREDIENT4_REFERENCE = 'ingredient4';
    public const INGREDIENT5_REFERENCE = 'ingredient5';


    public function load(ObjectManager $manager)
    {
        $ingredient1 = new Ingredient();
        $ingredient1->setName('Pommes de terre');
        $ingredient1->setIngredientQuantity(600);
        $ingredient1->setIngredientVolume("g");
        $ingredient2 = new Ingredient();
        $ingredient2->setName('Oignons');
        $ingredient2->setIngredientQuantity(400);
        $ingredient2->setIngredientVolume("g");
        $ingredient3 = new Ingredient();
        $ingredient3->setName('Carottes');
        $ingredient3->setIngredientQuantity(1);
        $ingredient3->setIngredientVolume("kg");
        $ingredient4 = new Ingredient();
        $ingredient4->setName('Poulet');
        $ingredient4->setIngredientQuantity(2);
        $ingredient4->setIngredientVolume("kg");
        $ingredient5 = new Ingredient();
        $ingredient5->setName('Fenouil');
        $ingredient5->setIngredientQuantity(500);
        $ingredient5->setIngredientVolume("g");

        $manager->persist($ingredient1);
        $manager->persist($ingredient2);
        $manager->persist($ingredient3);
        $manager->persist($ingredient4);
        $manager->persist($ingredient5);

        $this->addReference(self::INGREDIENT_REFERENCE , $ingredient1);
        $this->addReference(self::INGREDIENT2_REFERENCE, $ingredient2);
        $this->addReference(self::INGREDIENT3_REFERENCE, $ingredient3);
        $this->addReference(self::INGREDIENT4_REFERENCE, $ingredient4);
        $this->addReference(self::INGREDIENT5_REFERENCE, $ingredient5);

        $manager->flush();

    }
}