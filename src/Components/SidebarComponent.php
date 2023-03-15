<?php

namespace App\Components;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('sidebar')]
class SidebarComponent
{

    public array $groups;
    public User $user;


    public function mount(#[CurrentUser] ?User $user): void
    {
        $this->user = $user;
        $this->groups = $user->getGroups();
    }
}