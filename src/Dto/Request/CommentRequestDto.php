<?php

namespace App\Dto\Request;

class CommentRequestDto
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $post_id;

    /**
     * @var int
     */
    private $author_id;

    public function __construct(
        string $content,
        int $post_id,
        int $author_id
    )
    {
        $this->content = $content;
        $this->post_id = $post_id;
        $this->author_id = $author_id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }
}