<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $group = $this->getReference(GroupFixtures::GROUP_REFERENCE);
        $post1 = new Post();
        $post1->setContent('Allez voir mes recettes, c\'est banger, j\'espère que vous l\'apprecierai');
        $post1->setAuthor($this->getReference(UserFixtures::USER3_REFERENCE));
        $post1->setGroupId($group);
        $post1->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($post1);

        $post2 = new Post();
        $post2->setContent('Comme promis, la recette de mamie sera bientôt disponible, j\'espère que vous l\'apprecierai');
        $post2->setAuthor($this->getReference(UserFixtures::USER2_REFERENCE));
        $post2->setCreatedAt(new \DateTimeImmutable());
        $post2->setGroupId($group);
        $manager->persist($post2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GroupFixtures::class,
        ];
    }
}