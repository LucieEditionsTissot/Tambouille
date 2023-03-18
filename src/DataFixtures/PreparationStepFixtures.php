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
    public const PREPARATIONSTEP4_REFERENCE = 'preparationStep4';

    public function load(ObjectManager $manager)
    {
        $preparationStep1 = new PreparationStep();
        $preparationStep1->setDescription('Préchauffer le four à 210 °');
        $preparationStep1->setOrdre(1);
        $preparationStep1->setRecipe($this->getReference(RecipeFixtures::RECIPE_REFERENCE));

        $preparationStep2 = new PreparationStep();
        $preparationStep2->setDescription('Couper les carottes et les oignons en fines tranches');
        $preparationStep2->setOrdre(2);
        $preparationStep2->setRecipe($this->getReference(RecipeFixtures::RECIPE_REFERENCE));

        $preparationStep3 = new PreparationStep();
        $preparationStep3->setDescription('Ajouter du fenouil selon votre convenance');
        $preparationStep3->setOrdre(3);
        $preparationStep3->setRecipe($this->getReference(RecipeFixtures::RECIPE_REFERENCE));

        $preparationStep4 = new PreparationStep();
        $preparationStep4->setDescription('Faites cuire pendant 1h-1h10');
        $preparationStep4->setOrdre(4);
        $preparationStep4->setRecipe($this->getReference(RecipeFixtures::RECIPE_REFERENCE));

        $manager->persist($preparationStep1);
        $manager->persist($preparationStep2);
        $manager->persist($preparationStep3);
        $manager->persist($preparationStep4);

        $this->addReference(self::PREPARATIONSTEP_REFERENCE , $preparationStep1);
        $this->addReference(self::PREPARATIONSTEP2_REFERENCE, $preparationStep2);
        $this->addReference(self::PREPARATIONSTEP3_REFERENCE, $preparationStep3);
        $this->addReference(self::PREPARATIONSTEP4_REFERENCE, $preparationStep4);


        $manager->flush();
    }
    public function getOrder(): int
    {
        return 4;
    }
}