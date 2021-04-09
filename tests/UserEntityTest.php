<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testGettersAndSetters()
    {
        $this->user->setFirstName('John');
        $this->user->setLastName('Doe');
        $this->user->setEmail('john.doe@mail.com');
        $this->user->setUsername('john.doe');
        $this->user->setPassword('1234');

        $this->assertEquals($this->user->getFirstName(), 'John');
        $this->assertEquals($this->user->getLastName(), 'Doe');
        $this->assertEquals($this->user->getEmail(), 'john.doe@mail.com');
        $this->assertEquals($this->user->getUsername(), 'john.doe');
        $this->assertEquals($this->user->getPassword(), '1234');
    }

    public function testTrimingSetters()
    {
        $this->user->setFirstName('    John   ');
        $this->user->setLastName('   Doe    ');
        $this->user->setEmail('   john.doe@mail.com   ');
        $this->user->setUsername('   john.doe    ');
        $this->user->setPassword('     1234    ');

        $this->assertEquals($this->user->getFirstName(), 'John');
        $this->assertEquals($this->user->getLastName(), 'Doe');
        $this->assertEquals($this->user->getEmail(), 'john.doe@mail.com');
        $this->assertEquals($this->user->getUsername(), 'john.doe');
        $this->assertEquals($this->user->getPassword(), '1234');
    }
}