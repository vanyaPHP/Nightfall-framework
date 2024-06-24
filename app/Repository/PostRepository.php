<?php

namespace App\Repository;

use App\Entity\Post;
use Nightfall\Fallen\Attributes\Repository;
use Nightfall\Fallen\Repository\BaseRepository;

#[Repository(Post::class)]
class PostRepository extends BaseRepository
{

}