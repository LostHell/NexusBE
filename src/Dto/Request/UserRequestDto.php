<?php

namespace App\Dto\Request;

class UserRequestDto
{
    public $first_name;

    public $last_name;

    public $email;

    public $username;

    public $password;

    /**
     * @var PostRequestDto
     */
    public $posts;
}