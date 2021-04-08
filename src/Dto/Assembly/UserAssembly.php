<?php

namespace App\Dto\Assembly;

use App\Dto\Request\UserRequestDto;
use App\Dto\Response\UserResponseDto;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

class UserAssembly
{
    /**
     * @param UserRequestDto $dto
     * @param User|null $user
     * @return User
     */
    public function readDTO(UserRequestDto $dto, ?User $user = null): User
    {
        if (!$user) {
            $user = new User();
        }

        $user->setFirstName($dto->getFirstName());
        $user->setLastName($dto->getLastName());
        $user->setEmail($dto->getEmail());
        $user->setUsername($dto->getUsername());
        $user->setPassword($dto->getPassword());

        return $user;
    }

    /**
     * @param UserRequestDto $dto
     * @return User
     */
    public function createUser(UserRequestDto $dto): User
    {
        return $this->readDTO($dto);
    }

    /**
     * @param User $user
     * @return UserResponseDto
     */
    public function writeOneDTO(User $user): UserResponseDto
    {
        return new UserResponseDto(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getUsername()
        );
    }

    /**
     * @param array $users
     * @return ArrayCollection
     */
    public function writeManyDTOs(array $users): ArrayCollection
    {
        $arrayUsers = new ArrayCollection();

        foreach ($users as $item) {
            $user = new UserResponseDto(
                $item->getFirstName(),
                $item->getLastName(),
                $item->getEmail(),
                $item->getUsername()
            );

            $arrayUsers->add($user);
        }

        return $arrayUsers;
    }
}