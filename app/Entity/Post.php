<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Attributes\ManyToOne;
use Nightfall\Fallen\Attributes\OneToOne;
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

    #[ManyToOne(User::class, 'user_id', 'user_id')]
    #[Column('user_id', NumericTypes::INT)]
    private User $user;

    #[OneToOne(PostImage::class, 'post_id', 'post_id', false)]
    private PostImage $postImage;

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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPostImage(): PostImage
    {
        return $this->postImage;
    }

    public function setPostImage(PostImage $postImage): self
    {
        $this->postImage = $postImage;

        return $this;
    }
}