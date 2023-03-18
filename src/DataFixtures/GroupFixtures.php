<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $group1 = new Group();
        $group1->setName('La famille');
        $group1->setCode('GRP1');
        $manager->persist($group1);


        $user = $this->getReference(UserFixtures::USER_REFERENCE);
        $user2 = $this->getReference(UserFixtures::USER2_REFERENCE);
        $user3 = $this->getReference(UserFixtures::USER3_REFERENCE);
        $user4 = $this->getReference(UserFixtures::USER4_REFERENCE);

        $group1->addUser($user);
        $group1->addUser($user2);

        $group1->addUser($user3);
        $group1->addUser($user4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}