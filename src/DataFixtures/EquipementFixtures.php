<?php

namespace App\DataFixtures;

use App\Entity\Equipement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipementFixtures extends Fixture
{

    public const EQUIPEMENT_REFERENCE = 'EQUIPEMENT1';
    public const EQUIPEMENT2_REFERENCE = 'EQUIPEMENT2';
    public const EQUIPEMENT3_REFERENCE = 'EQUIPEMENT3';
    public const EQUIPEMENT4_REFERENCE = 'EQUIPEMENT4';

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

        $this->addReference(self::EQUIPEMENT_REFERENCE, $equipement1);
        $this->addReference(self::EQUIPEMENT2_REFERENCE, $equipement2);
        $this->addReference(self::EQUIPEMENT3_REFERENCE, $equipement3);
        $this->addReference(self::EQUIPEMENT4_REFERENCE, $equipement4);


        $manager->flush();
    }
}
