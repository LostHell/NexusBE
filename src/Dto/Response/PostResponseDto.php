<?php

namespace App\Dto\Response;

class PostResponseDto
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $date_created;

    /**
     * @var \DateTime
     */
    private $date_last_update;

    /**
     * @var array
     */
    private $user;

    /**
     * @var object
     */
    private $comment;

    public function __construct(
        string $content,
        \DateTimeInterface $date_created,
        \DateTimeInterface $date_last_update,
        array $user,
        object $comment)
    {
        $this->content = $content;
        $this->date_created = $date_created;
        $this->date_last_update = $date_last_update;
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->date_created;
    }

    /**
     * @return \DateTime
     */
    public function getDateLastUpdate(): \DateTime
    {
        return $this->date_last_update;
    }

    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @return object
     */
    public function getComment(): object
    {
        return $this->comment;
    }
}