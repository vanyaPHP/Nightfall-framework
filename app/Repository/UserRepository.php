<?php

namespace App\Repository;

use App\Entity\User;
use Nightfall\Fallen\Attributes\Repository;
use Nightfall\Fallen\Repository\BaseRepository;

#[Repository(User::class)]
class UserRepository extends BaseRepository
{

}