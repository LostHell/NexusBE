<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $newUser
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(User $newUser)
    {
        $em = $this->getEntityManager();
        $em->persist($newUser);
        $em->flush();

        return $newUser;
    }

    /**
     * @param int $id
     * @param User $user
     * @return User
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(int $id, User $user)
    {
        $currentUser = $this->find($id);

        $currentUser->setFirstName($user->getFirstName());
        $currentUser->setLastName($user->getLastName());
        $currentUser->setEmail($user->getEmail());
        $currentUser->setUsername($user->getUsername());
        $currentUser->setPassword($user->getPassword());

        $em= $this->getEntityManager();
        $em->persist($currentUser);
        $em->flush();

        return $currentUser;
    }
}
