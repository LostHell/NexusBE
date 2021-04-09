<?php

namespace App\Dto\Response;

class CommentResponseDto
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTimeInterface
     */
    private $date_created;

    /**
     * @var \DateTimeInterface
     */
    private $date_last_update;

    /**
     * @var array
     */
    private $post;

    /**
     * @var array
     */
    private $user;


    public function __construct(
        string $content,
        \DateTimeInterface $date_created,
        \DateTimeInterface $date_last_update,
        array $post,
        array $user)
    {
        $this->content = $content;
        $this->date_created = $date_created;
        $this->date_last_update = $date_last_update;
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateCreated(): \DateTimeInterface
    {
        return $this->date_created;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateLastUpdate(): \DateTimeInterface
    {
        return $this->date_last_update;
    }

    /**
     * @return array[]
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @return array[]
     */
    public function getUser(): array
    {
        return $this->user;
    }
}