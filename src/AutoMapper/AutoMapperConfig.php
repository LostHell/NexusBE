<?php

namespace App\AutoMapper;

use App\Dto\Request\PostRequestDto;
use App\Dto\Request\UserRequestDto;
use App\Dto\Response\PostResponseDto;
use App\Dto\Response\UserResponseDto;
use App\Entity\Post;
use App\Entity\User;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\MappingOperation\Operation;

class AutoMapperConfig implements AutoMapperConfiguratorInterface
{

    public function configure(AutoMapperConfigInterface $config): void
    {
        // ResponseDto Mapping
        $config->registerMapping(User::class, UserResponseDto::class);

        $config->registerMapping(Post::class, PostResponseDto::class)
            ->forMember('author', function (Post $source) {
                return [
                    'first_name' => $source->getAuthor()->getFirstName(),
                    'last_name' => $source->getAuthor()->getLastName()];
            });

        // RequestDto Mapping
        $config->registerMapping(UserRequestDto::class, User::class);

        // TO DO... Must implementing!!!!
        $config->registerMapping(UserRequestDto::class, User::class)
            ->forMember('posts', Operation::mapTo(Post::class));
    }
}