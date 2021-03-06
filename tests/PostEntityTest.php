<?php

namespace App\Tests;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostEntityTest extends TestCase
{
    protected $post;

    public function setUp(): void
    {
        $this->post = new Post();
    }

    public function testGettersAndSetters()
    {
        $this->post->setContent('Something');
        $this->post->setDateCreated(new \DateTime("01-01-2021"));
        $this->post->setDateLastUpdate(new \DateTime("03-03-2021"));
        $this->post->setAuthor(null);

        $this->assertEquals($this->post->getContent(),'Something');
        $this->assertEquals($this->post->getDateCreated(),new \DateTime("01-01-2021"));
        $this->assertEquals($this->post->getDateLastUpdate(),new \DateTime("03-03-2021"));
        $this->assertEquals($this->post->getAuthor(),null);
    }

    public function testTrimingSetters()
    {
        $this->post->setContent('   Just Something      ');
        $this->post->setDateCreated(new \DateTime("    01-01-2021      "));

        $this->assertEquals($this->post->getContent(),'Just Something');
        $this->assertEquals($this->post->getDateCreated(),new \DateTime("01-01-2021"));
    }
}