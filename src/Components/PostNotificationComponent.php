<?php

namespace App\Components;

use App\Entity\Post;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('post_notification')]
class PostNotificationComponent
{
    public Post $post;
}