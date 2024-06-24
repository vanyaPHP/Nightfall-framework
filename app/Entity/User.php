<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Types\NumericTypes;

#[Entity('users', UserRepository::class)]
class User
{
    #[Id]
    #[Column('user_id', NumericTypes::INT)]
    private int $id;

    #[Column]
    private string $username;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}