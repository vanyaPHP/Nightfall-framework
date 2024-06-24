<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Attributes\OneToMany;
use Nightfall\Fallen\Collection\GenericCollection;
use Nightfall\Fallen\Types\NumericTypes;

#[Entity('users', UserRepository::class)]
class User
{
    #[Id]
    #[Column('user_id', NumericTypes::INT)]
    private int $id;

    #[Column]
    private string $username;

    #[OneToMany(Post::class, 'user_id', 'user_id')]
    private GenericCollection $posts;

    public function __construct()
    {
        $this->posts = new GenericCollection([]);
    }

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

    public function addPost(Post $post): self
    {
        $this->posts->add($post);

        return $this;
    }

    public function removePost(Post $postToRemove): self
    {
        $this->posts = $this->posts
            ->filter(fn (Post $post) => $post != $postToRemove);

        return $this;
    }
}