<?php

namespace App\Components;

use App\Entity\Recipe;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('recipe')]
class RecipesComponent
{
public Recipe $recipe;
}