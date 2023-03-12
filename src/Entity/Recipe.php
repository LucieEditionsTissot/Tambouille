<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $cookingTime = null;

    #[ORM\Column]
    private ?int $nbPersons = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(Types::ARRAY)]
    private array $recipeType;

    #[ORM\ManyToMany(targetEntity: Equipement::class, inversedBy: 'recipes')]
    private Collection $equipements;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: IngredientQuantity::class)]
    private Collection $ingredients;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: PreparationStep::class)]
    private Collection $steps;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Image::class)]
    private Collection $image;

    public function __construct()
    {
        $this->equipements = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->steps = new ArrayCollection();
        $this->image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCookingTime(): ?int
    {
        return $this->cookingTime;
    }

    public function setCookingTime(int $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }


    public function getNbPersons(): ?int
    {
        return $this->nbPersons;
    }

    public function setNbPersons(int $nbPersons): self
    {
        $this->nbPersons = $nbPersons;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }


    public function getRecipeType(): ?array
    {
        return $this->recipeType;
    }

    public function setRecipeType(?array $recipeType): self
    {
        $this->recipeType = $recipeType;

        return $this;
    }

    /**
     * @return Collection<int, Equipement>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements->add($equipement);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        $this->equipements->removeElement($equipement);

        return $this;
    }

    /**
     * @return Collection<int, IngredientQuantity>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(IngredientQuantity $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(IngredientQuantity $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PreparationStep>
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(PreparationStep $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
            $step->setRecipe($this);
        }

        return $this;
    }

    public function removeStep(PreparationStep $step): self
    {
        if ($this->steps->removeElement($step)) {
            // set the owning side to null (unless already changed)
            if ($step->getRecipe() === $this) {
                $step->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setRecipe($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            if ($image->getRecipe() === $this) {
                $image->setRecipe(null);
            }
        }

        return $this;
    }
    public function setImageFile(UploadedFile $file): self
    {
        $image = new Image();
        $filename = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getUploadRootDir(), $filename);
        $image->setFilename($filename);
        $image->setPath($this->getUploadDir() . '/' . $filename);
        $image->setRecipe($this);
        $this->image->add($image);

        return $this;
    }
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../public/uploads/recipes';
    }

    protected function getUploadDir()
    {
        return 'uploads/recipes';
    }
}
