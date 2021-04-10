<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @return Comment[]
     */
    public function getAllComments(): array
    {
        $comments = $this->findAll();

        if (count($comments) === 0) {
            throw new NotFoundHttpException();
        }

        return $comments;
    }

    /**
     * @param int $id
     * @return Comment
     */
    public function getCommentById(int $id): Comment
    {
        $comment = $this->find($id);

        if (is_null($comment)) {
            throw new NotFoundHttpException("Comment with id: $id not found!");
        }

        return $comment;
    }

    /**
     * @param Comment $comment
     * @return Comment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Comment $comment): Comment
    {
        $comment->setDateCreated(new \DateTime());
        $comment->setDateLastUpdate(new \DateTime());

        $em = $this->getEntityManager();
        $em->persist($comment);
        $em->flush();

        return $comment;
    }


    /**
     * @param int $id
     * @param Comment $comment
     * @return Comment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(int $id, Comment $comment): Comment
    {
        $currentComment = $this->find($id);

        $currentComment->setContent($comment->getContent());
        $currentComment->setDateLastUpdate(new \DateTime());

        $em = $this->getEntityManager();
        $em->persist($currentComment);
        $em->flush();

        return $currentComment;
    }

    /**
     * @param int $id
     * @return Comment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(int $id): Comment
    {
        $comment = $this->find($id);

        $em = $this->getEntityManager();
        $em->remove($comment);
        $em->flush();

        return $comment;
    }
}
