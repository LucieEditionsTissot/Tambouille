<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $group = $this->getReference(GroupFixtures::GROUP_REFERENCE);
        $groupId = $group->getId();
        $post1 = new Post();
        $post1->setContent('This is my very first blog post');
        $post1->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $post1->setGroupId($groupId);
        $post1->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($post1);

        $post2 = new Post();
        $post2->setContent('This is my second blog post');
        $post2->setAuthor($this->getReference(UserFixtures::USER_REFERENCE));
        $post2->setCreatedAt(new \DateTimeImmutable());
        $post2->setGroupId($groupId);
        $manager->persist($post2);

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 8;
    }
}