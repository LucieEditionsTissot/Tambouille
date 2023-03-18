<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('ryan.gosling@love.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, '1mot2passeSTP'));
        $user->setUsername('Ryry');
        $user->setImage('Ryan-Gosling-PNG-HD-Image.png');
        $user->setPhone('0123456789');
        $user->setRoles(['ROLE_USER']);


        $user2 = new User();
        $user2->setEmail('rihanna.bossbitch@love.com');
        $user2->setPassword($this->passwordHasher->hashPassword($user2, '1mot2passeSTP'));
        $user2->setUsername('Riri');
        $user2->setImage('png-clipart-rihanna.png');
        $user2->setPhone('0123456789');
        $user2->setRoles(['ROLE_USER']);

        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();
    }
}