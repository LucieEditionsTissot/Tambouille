<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends AbstractFixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $referenceRepository = new ReferenceRepository($manager);

        $userFixtures = new UserFixtures($this->passwordHasher);
        $userFixtures->load($manager);

        $referenceRepository->setReference(UserFixtures::USER_REFERENCE, $userFixtures->getReference(UserFixtures::USER_REFERENCE));
        $referenceRepository->setReference(UserFixtures::USER2_REFERENCE, $userFixtures->getReference(UserFixtures::USER2_REFERENCE));

        $groupFixtures = new GroupFixtures();

        $groupFixtures->setReferenceRepository($referenceRepository);

        $groupFixtures->load($manager);

        $referenceRepository->setReference(GroupFixtures::GROUP_REFERENCE, $groupFixtures->getReference(GroupFixtures::GROUP_REFERENCE));

        $manager->flush();
    }
}