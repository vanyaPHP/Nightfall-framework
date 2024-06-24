<?php

namespace App\Entity;

use App\Repository\PostImageRepository;
use Nightfall\Fallen\Attributes\Column;
use Nightfall\Fallen\Attributes\Entity;
use Nightfall\Fallen\Attributes\Id;
use Nightfall\Fallen\Attributes\OneToOne;
use Nightfall\Fallen\Types\NumericTypes;

#[Entity('post_images', PostImageRepository::class)]
class PostImage
{
    #[Id]
    #[Column('post_image_id', NumericTypes::INT)]
    private int $id;

    #[Column('post_image_url', length: 100)]
    private string $postImageUrl;

    #[OneToOne(Post::class, 'post_id', 'post_id')]
    #[Column('post_id', NumericTypes::INT)]
    private Post $post;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPostImageUrl(): string
    {
        return $this->postImageUrl;
    }

    public function setPostImageUrl(string $postImageUrl): self
    {
        $this->postImageUrl = $postImageUrl;

        return $this;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}