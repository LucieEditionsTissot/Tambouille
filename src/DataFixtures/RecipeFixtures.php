<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $recipe = new Recipe();
        $recipe->setTitle('My First Recipe');
        $recipe->setDescription('A simple recipe to get started');
        $recipe->setImage('recipe1.jpg');

        $recipe->addIngredient($this->getReference('INGREDIENT1_REFERENCE'));
        $recipe->addIngredient($this->getReference('INGREDIENT2_REFERENCE'));
        $recipe->addEquipement($this->getReference('EQUIPMENT1_REFERENCE'));
        $recipe->addPreparationStep($this->getReference('PREPARATION_STEP1_REFERENCE'));

        $manager->persist($recipe);
        $manager->flush();
    }
}