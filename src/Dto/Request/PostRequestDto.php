<?php

namespace App\Dto\Request;

use App\Entity\User;

class PostRequestDto
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $author_id;

    public function __construct(string $content, int $author_id)
    {
        $this->content = $content;
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
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

}