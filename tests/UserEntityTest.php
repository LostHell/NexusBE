<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('john.doe@mail.com');
        $user->setUsername('john.doe');
        $user->setPassword('1234');

        $this->assertEquals($user->getFirstName(),'John');
        $this->assertEquals($user->getLastName(),'Doe');
        $this->assertEquals($user->getEmail(),'john.doe@mail.com');
        $this->assertEquals($user->getUsername(),'john.doe');
        $this->assertEquals($user->getPassword(),'1234');
    }

    public function testTrimingSetters()
    {
        $user = new User();
        $user->setFirstName('    John   ');
        $user->setLastName('   Doe    ');
        $user->setEmail('   john.doe@mail.com   ');
        $user->setUsername('   john.doe    ');
        $user->setPassword('     1234    ');

        $this->assertEquals($user->getFirstName(),'John');
        $this->assertEquals($user->getLastName(),'Doe');
        $this->assertEquals($user->getEmail(),'john.doe@mail.com');
        $this->assertEquals($user->getUsername(),'john.doe');
        $this->assertEquals($user->getPassword(),'1234');
    }
}