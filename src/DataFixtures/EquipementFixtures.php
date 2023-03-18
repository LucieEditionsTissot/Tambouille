<?php

namespace App\DataFixtures;

use App\Entity\Equipement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $equipement1 = new Equipement();
        $equipement1->setName('Casserole');

        $equipement2 = new Equipement();
        $equipement2->setName('Poêle');

        $equipement3 = new Equipement();
        $equipement3->setName('Fouet');

        $equipement4 = new Equipement();
        $equipement4->setName('Four');

        $manager->persist($equipement1);
        $manager->persist($equipement2);
        $manager->persist($equipement3);
        $manager->persist($equipement4);


        $manager->flush();
    }
}
