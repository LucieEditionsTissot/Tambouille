<?php

namespace App\Transformer;

use App\Entity\Equipement;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EquipementTransformer implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($equipements)
    {
        // transform the collection of equipements into an array
        $choices = [];
        foreach ($equipements as $equipement) {
            $choices[] = $equipement->getId();
        }
        return $choices;
    }

    public function reverseTransform($choices)
    {
        // reverse transform the array of choices into a collection of equipements
        $equipements = new ArrayCollection();
        foreach ($choices as $choice) {
            $equipement = $this->entityManager->getRepository(Equipement::class)->find($choice);
            if (null === $equipement) {
                throw new TransformationFailedException(sprintf('An equipement with id "%s" does not exist!', $choice));
            }
            $equipements->add($equipement);
        }
        return $equipements;
    }
}
