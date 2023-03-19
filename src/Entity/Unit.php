<?php

namespace App\Entity;

use App\Repository\UnitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'unit', targetEntity: IngredientQuantity::class)]
    private Collection $ingredientQuantities;

    public function __construct()
    {
        $this->ingredientQuantities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, IngredientQuantity>
     */
    public function getIngredientQuantities(): Collection
    {
        return $this->ingredientQuantities;
    }

    public function addIngredientQuantity(IngredientQuantity $ingredientQuantity): self
    {
        if (!$this->ingredientQuantities->contains($ingredientQuantity)) {
            $this->ingredientQuantities->add($ingredientQuantity);
            $ingredientQuantity->setUnit($this);
        }

        return $this;
    }

    public function removeIngredientQuantity(IngredientQuantity $ingredientQuantity): self
    {
        if ($this->ingredientQuantities->removeElement($ingredientQuantity)) {
            // set the owning side to null (unless already changed)
            if ($ingredientQuantity->getUnit() === $this) {
                $ingredientQuantity->setUnit(null);
            }
        }

        return $this;
    }
}
