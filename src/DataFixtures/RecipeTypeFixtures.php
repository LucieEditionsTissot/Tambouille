<?php

namespace App\DataFixtures;

use App\Entity\RecipeType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeTypeFixtures extends Fixture
{
    public const RECIPETYPE1_REFERENCE = 'recipeType1';
    public const RECIPETYPE2_REFERENCE = 'recipeType2';
    public const RECIPETYPE3_REFERENCE = 'recipeType3';
    public const RECIPETYPE4_REFERENCE = 'recipeType4';
    
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

        $this->addReference(self::RECIPETYPE1_REFERENCE, $recipeType1);
        $this->addReference(self::RECIPETYPE2_REFERENCE, $recipeType2);
        $this->addReference(self::RECIPETYPE3_REFERENCE, $recipeType3);
        $this->addReference(self::RECIPETYPE4_REFERENCE, $recipeType4);

        $manager->flush();
    }

}