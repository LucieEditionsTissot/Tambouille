<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{

    public const RECIPE_REFERENCE = 'recipe';
    public const RECIPE2_REFERENCE = 'recipe2';
    public const RECIPE3_REFERENCE = 'recipe3';

    public function load(ObjectManager $manager)
    {
        $group = $this->getReference(GroupFixtures::GROUP_REFERENCE);
        $recipe = new Recipe();
        $recipe->setTitle('Le poulet rôti de mamie');
        $recipe->setDescription('Parce que je suis la seule personne de la famille à l\'avoir');
        $recipe->setAuthor($this->getReference(UserFixtures::USER2_REFERENCE));
        $recipe->setImages('png-clipart-barbecue-chicken-roast-chicken-fried-chicken-fried-chicken-barbecue-food.png');
        $recipe->setGroupId($group);
        $recipe->setCookingTime(120);
        $recipe->setNbPersons(6);



        $recipe->addIngredient($this->getReference(IngredientFixtures::INGREDIENT2_REFERENCE));
        $recipe->addIngredient($this->getReference(IngredientFixtures::INGREDIENT3_REFERENCE));
        $recipe->addIngredient($this->getReference(IngredientFixtures::INGREDIENT4_REFERENCE));
        $recipe->addIngredient($this->getReference(IngredientFixtures::INGREDIENT5_REFERENCE));

        $recipe->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT_REFERENCE));
        $recipe->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT2_REFERENCE));
        $recipe->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT3_REFERENCE));
        $recipe->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT4_REFERENCE));



        $recipe->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP_REFERENCE));
        $recipe->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP2_REFERENCE));
        $recipe->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP3_REFERENCE));
        $recipe->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP4_REFERENCE));


        $recipe2 = new Recipe();
        $recipe2->setTitle('Le Tiramisu ');
        $recipe2->setDescription('Le best tiramisu du monde tu peux pas test');
        $recipe2->setAuthor($this->getReference(UserFixtures::USER3_REFERENCE));
        $recipe2->setImages('png-transparent-square-cake-beside-spoon-coffee-tiramisu-ladyfinger-italian-cuisine-chocolate-cake-chocolate-cake-with-spoon-cream-food-frozen-dessert.png');
        $recipe2->setGroupId($group);
        $recipe2->setCookingTime(30);
        $recipe2->setNbPersons(4);

        $recipe2->addIngredient($this->getReference(IngredientFixtures::INGREDIENT_REFERENCE));
        $recipe2->addIngredient($this->getReference(IngredientFixtures::INGREDIENT2_REFERENCE));
        $recipe2->addIngredient($this->getReference(IngredientFixtures::INGREDIENT3_REFERENCE));
        $recipe2->addIngredient($this->getReference(IngredientFixtures::INGREDIENT4_REFERENCE));
        $recipe2->addIngredient($this->getReference(IngredientFixtures::INGREDIENT5_REFERENCE));

        $recipe2->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT_REFERENCE));
        $recipe2->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT2_REFERENCE));
        $recipe2->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT3_REFERENCE));
        $recipe2->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT4_REFERENCE));



        $recipe2->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP_REFERENCE));
        $recipe2->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP2_REFERENCE));
        $recipe2->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP3_REFERENCE));
        $recipe2->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP4_REFERENCE));

        $recipe3 = new Recipe();
        $recipe3->setTitle('Le meilleur boeuf bourguignon vegan');
        $recipe3->setDescription('J\'ai essayé une nouvelle recette de boeuf bourguignon vegan, vous m\'en direz des nouvelles');
        $recipe3->setAuthor($this->getReference(UserFixtures::USER3_REFERENCE));
        $recipe3->setImages('kisspng-daube-recipe-beef-bourguignon-pressure-cooking-food-recipe-5b2de80842e8b9.5695632915297351762741.png');
        $recipe3->setGroupId($group);
        $recipe3->addIngredient($this->getReference(IngredientFixtures::INGREDIENT_REFERENCE));
        $recipe3->setCookingTime(30);
        $recipe3->setNbPersons(4);

        $recipe3->addIngredient($this->getReference(IngredientFixtures::INGREDIENT2_REFERENCE));
        $recipe3->addIngredient($this->getReference(IngredientFixtures::INGREDIENT3_REFERENCE));
        $recipe3->addIngredient($this->getReference(IngredientFixtures::INGREDIENT4_REFERENCE));
        $recipe3->addIngredient($this->getReference(IngredientFixtures::INGREDIENT5_REFERENCE));

        $recipe3->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT_REFERENCE));
        $recipe3->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT2_REFERENCE));
        $recipe3->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT3_REFERENCE));
        $recipe3->addEquipement($this->getReference(EquipementFixtures::EQUIPEMENT4_REFERENCE));

        $recipe3->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP_REFERENCE));
        $recipe3->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP2_REFERENCE));
        $recipe3->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP3_REFERENCE));
        $recipe3->addPreparationStep($this->getReference(PreparationStepFixtures::PREPARATIONSTEP4_REFERENCE));

        $manager->persist($recipe);
        $manager->persist($recipe2);
        $manager->persist($recipe3);

        $this->addReference(self::RECIPE_REFERENCE, $recipe);
        $this->addReference(self::RECIPE2_REFERENCE, $recipe2);
        $this->addReference(self::RECIPE3_REFERENCE, $recipe3);

        $manager->flush();


    }
    public function getDependencies()
    {
        return [
            GroupFixtures::class,
            IngredientFixtures::class,
            PreparationStepFixtures::class,
        ];
    }

}