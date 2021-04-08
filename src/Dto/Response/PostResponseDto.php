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

    public function __construct(
        string $content,
        \DateTimeInterface $date_created,
        \DateTimeInterface $date_last_update)
    {
        $this->content = $content;
        $this->date_created = $date_created;
        $this->date_last_update = $date_last_update;
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
}