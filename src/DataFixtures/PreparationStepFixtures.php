<?php

namespace App\DataFixtures;

use App\Entity\PreparationStep;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PreparationStepFixtures extends Fixture
{
    public const PREPARATIONSTEP_REFERENCE = 'preparationStep1';
    public const PREPARATIONSTEP2_REFERENCE = 'preparationStep2';
    public const PREPARATIONSTEP3_REFERENCE = 'preparationStep3';
    public const PREPARATIONSTEP4_REFERENCE = 'preparationStep44';
    
    public function load(ObjectManager $manager)
    {
        $preparationStep1 = new PreparationStep();
        $preparationStep1->setDescription('Preparation step 1 for recipe A.');
        $preparationStep1->setOrdre(1);
        $preparationStep1->setRecipe($this->getReference('recipe-A'));

        $preparationStep2 = new PreparationStep();
        $preparationStep2->setDescription('Preparation step 2 for recipe A.');
        $preparationStep2->setOrdre(2);
        $preparationStep2->setRecipe($this->getReference('recipe-A'));

        $preparationStep3 = new PreparationStep();
        $preparationStep3->setDescription('Preparation step 1 for recipe B.');
        $preparationStep3->setOrdre(1);
        $preparationStep3->setRecipe($this->getReference('recipe-B'));

        $preparationStep4 = new PreparationStep();
        $preparationStep4->setDescription('Preparation step 2 for recipe B.');
        $preparationStep4->setOrdre(2);
        $preparationStep4->setRecipe($this->getReference('recipe-B'));

        $manager->persist($preparationStep1);
        $manager->persist($preparationStep2);
        $manager->persist($preparationStep3);
        $manager->persist($preparationStep4);

        $manager->flush();
    }
}





