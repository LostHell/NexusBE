<?php

namespace App\Tests;

use App\Entity\Post;
use PHPUnit\Framework\TestCase;

class PostEntityTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $post = new Post();
        $post->setContent('Something');
        $post->setDateCreated(new \DateTime("01-01-2021"));
        $post->setDateLastUpdate(new \DateTime("03-03-2021"));
        $post->setAuthor(null);

        $this->assertEquals($post->getContent(),'Something');
        $this->assertEquals($post->getDateCreated(),new \DateTime("01-01-2021"));
        $this->assertEquals($post->getDateLastUpdate(),new \DateTime("03-03-2021"));
        $this->assertEquals($post->getAuthor(),null);
    }

    public function testTrimingSetters()
    {
        $post = new Post();
        $post->setContent('   Just Something      ');
        $post->setDateCreated(new \DateTime("    01-01-2021      "));

        $this->assertEquals($post->getContent(),'Just Something');
        $this->assertEquals($post->getDateCreated(),new \DateTime("01-01-2021"));
    }
}