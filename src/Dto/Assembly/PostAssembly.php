<?php

namespace App\Dto\Assembly;

use App\Dto\Request\PostRequestDto;
use App\Dto\Response\PostResponseDto;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class PostAssembly
{
    public function readDTO(PostRequestDto $dto, ?Post $post = null, ?User $user = null): Post
    {
        if (!$post) {
            $post = new Post();
        }

        $post->setContent($dto->getContent());
        $user->addPost($post);

        return $post;
    }

    /**
     * @param PostRequestDto $dto
     * @return Post
     */
    public function createPost(PostRequestDto $dto): Post
    {
        return $this->readDTO($dto);
    }

    /**
     * @param Post $post
     * @return PostResponseDto
     */
    public function writeOneDTO(Post $post): PostResponseDto
    {
        return new PostResponseDto(
            $post->getContent(),
            $post->getDateCreated(),
            $post->getDateLastUpdate()
        );
    }

    /**
     * @param array $posts
     * @return ArrayCollection
     */
    public function writeManyDTOs(array $posts): ArrayCollection
    {
        $arrayPosts = new ArrayCollection();

        foreach ($posts as $item) {
            $post = new PostResponseDto(
                $item->getContent(),
                $item->getDateCreated(),
                $item->getDateLastUpdate()
            );

            $arrayPosts->add($post);
        }

        return $arrayPosts;
    }
}