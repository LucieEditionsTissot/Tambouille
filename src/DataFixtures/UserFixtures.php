<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public const USER_REFERENCE = 'user';
    public const USER2_REFERENCE = 'user2';
    public const USER3_REFERENCE = 'user3';
    public const USER4_REFERENCE = 'user4';


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


        $user3 = new User();
        $user3->setEmail('keanu.reeves@love.com');
        $user3->setPassword($this->passwordHasher->hashPassword($user3, '1mot2passeSTP'));
        $user3->setUsername('KeanuBear');
        $user3->setImage('730-7308587_keanu-reeves-png.png');
        $user3->setPhone('0123456789');
        $user3->setRoles(['ROLE_USER']);

        $user4 = new User();
        $user4->setEmail('beyonce.queenb@love.com');
        $user4->setPassword($this->passwordHasher->hashPassword($user4, '1mot2passeSTP'));
        $user4->setUsername('QueenB');
        $user4->setImage('Beyonce-PNG-Picture.png');
        $user4->setPhone('0123456789');
        $user4->setRoles(['ROLE_USER']);

        $manager->persist($user);

        $manager->flush();
        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        $this->addReference(self::USER_REFERENCE, $user);
        $this->addReference(self::USER2_REFERENCE, $user2);
        $this->addReference(self::USER3_REFERENCE, $user3);
        $this->addReference(self::USER4_REFERENCE, $user4);

        $manager->flush();
    }


}