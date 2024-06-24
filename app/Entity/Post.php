<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Types\NumericTypes;
use Nightfall\Fallen\Types\StringTypes;

#[Entity('posts', PostRepository::class)]
class Post
{
    #[Id]
    #[Column('post_id', NumericTypes::INT)]
    private int $id;

    #[Column]
    private string $title;

    #[Column(type: StringTypes::TEXT)]
    private string $description;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        
        return $this;
    }
}