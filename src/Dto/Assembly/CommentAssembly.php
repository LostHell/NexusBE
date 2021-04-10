<?php

namespace App\Dto\Assembly;

use App\Dto\Request\CommentRequestDto;
use App\Dto\Response\CommentResponseDto;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class CommentAssembly
{
    /**
     * @param CommentRequestDto $dto
     * @param Comment|null $comment
     * @param Post|null $post
     * @param User|null $user
     * @return Comment|null
     */
    public function readDTO(
        CommentRequestDto $dto,
        ?Comment $comment = null,
        ?Post $post = null,
        ?User $user = null): ?Comment
    {
        if (!$comment) {
            $comment = new Comment();
        }

        $comment->setContent($dto->getContent());
        if ($post) {
            $post->addComment($comment);
        }
        if ($user) {
            $user->addComment($comment);
        }

        return $comment;
    }

    /**
     * @param Comment $comment
     * @return CommentResponseDto
     */
    public function writeOneDTO(Comment $comment): CommentResponseDto
    {
        return new CommentResponseDto(
            $comment->getContent(),
            $comment->getDateCreated(),
            $comment->getDateLastUpdate(),
            ['content' => $comment->getPost()->getContent(),
                'dateCreated' => $comment->getPost()->getDateCreated(),
                'dateLastUpdate' => $comment->getPost()->getDateLastUpdate()],
            ['username' => $comment->getAuthor()->getUsername(),
                'fullName' => $comment->getAuthor()->getFirstName() . ' ' . $comment->getAuthor()->getLastName()]
        );
    }

    /**
     * @param array $comments
     * @return ArrayCollection
     */
    public function writeManyDTOs(array $comments): ArrayCollection
    {
        $arrayComments = new ArrayCollection();

        foreach ($comments as $item) {
            $comment = new CommentResponseDto(
                $item->getContent(),
                $item->getDateCreated(),
                $item->getDateLastUpdate(),
                ['content' => $item->getPost()->getContent(),
                    'dateCreated' => $item->getPost()->getDateCreated(),
                    'dateLastUpdate' => $item->getPost()->getDateLastUpdate()],
                ['username' => $item->getAuthor()->getUsername(),
                    'fullName' => $item->getAuthor()->getFirstName() . ' ' . $item->getAuthor()->getLastName()]
            );

            $arrayComments->add($comment);
        }

        return $arrayComments;
    }
}