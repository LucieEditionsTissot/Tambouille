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

    #[ORM\ManyToMany(targetEntity: PreparationStep::class, mappedBy: 'ingredients')]
    private Collection $preparationSteps;

    #[ORM\Column(length: 255)]
    private ?string $ingredientType = null;

    #[ORM\Column]
    private ?int $ingredientQuantity = null;

    #[ORM\Column(length: 255)]
    private ?string $ingredientVolume = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    private ?Recipe $recipe = null;

    public function __construct()
    {
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

    public function getIngredientType(): ?string
    {
        return $this->ingredientType;
    }

    public function setIngredientType(string $ingredientType): self
    {
        $this->ingredientType = $ingredientType;

        return $this;
    }

    public function getIngredientQuantity(): ?int
    {
        return $this->ingredientQuantity;
    }

    public function setIngredientQuantity(int $ingredientQuantity): self
    {
        $this->ingredientQuantity = $ingredientQuantity;

        return $this;
    }

    public function getIngredientVolume(): ?string
    {
        return $this->ingredientVolume;
    }

    public function setIngredientVolume(string $ingredientVolume): self
    {
        $this->ingredientVolume = $ingredientVolume;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }
}
