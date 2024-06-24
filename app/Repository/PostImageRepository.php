<?php

namespace App\Repository;

use App\Entity\PostImage;
use Nightfall\Fallen\Attributes\Repository;
use Nightfall\Fallen\Repository\BaseRepository;

#[Repository(PostImage::class)]
class PostImageRepository extends BaseRepository
{

}