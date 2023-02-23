<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?IngredientFamily $ingredientFamily = null;

    #[ORM\OneToMany(mappedBy: 'ingredient', targetEntity: IngredientQuantity::class)]
    private Collection $ingredientQuantities;

    #[ORM\ManyToMany(targetEntity: PreparationStep::class, mappedBy: 'ingredients')]
    private Collection $preparationSteps;

    public function __construct()
    {
        $this->ingredientQuantities = new ArrayCollection();
        $this->preparationSteps = new ArrayCollection();
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

    public function getIngredientFamily(): ?IngredientFamily
    {
        return $this->ingredientFamily;
    }

    public function setIngredientFamily(?IngredientFamily $ingredientFamily): self
    {
        $this->ingredientFamily = $ingredientFamily;

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
            $ingredientQuantity->setIngredient($this);
        }

        return $this;
    }

    public function removeIngredientQuantity(IngredientQuantity $ingredientQuantity): self
    {
        if ($this->ingredientQuantities->removeElement($ingredientQuantity)) {
            // set the owning side to null (unless already changed)
            if ($ingredientQuantity->getIngredient() === $this) {
                $ingredientQuantity->setIngredient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PreparationStep>
     */
    public function getPreparationSteps(): Collection
    {
        return $this->preparationSteps;
    }

    public function addPreparationStep(PreparationStep $preparationStep): self
    {
        if (!$this->preparationSteps->contains($preparationStep)) {
            $this->preparationSteps->add($preparationStep);
            $preparationStep->addIngredient($this);
        }

        return $this;
    }

    public function removePreparationStep(PreparationStep $preparationStep): self
    {
        if ($this->preparationSteps->removeElement($preparationStep)) {
            $preparationStep->removeIngredient($this);
        }

        return $this;
    }
}
