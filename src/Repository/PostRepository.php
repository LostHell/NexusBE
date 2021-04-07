<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @return Post[]
     */
    public function getAllPosts()
    {
        $posts = $this->findAll();

        if (count($posts) === 0) {
            throw new NotFoundHttpException();
        }

        return $posts;
    }

    /**
     * @param int $id
     * @return Post
     */
    public function getPostById(int $id)
    {
        $post = $this->find($id);

        if (is_null($post)) {
            throw new NotFoundHttpException("Post with id: $id not found!");
        }

        return $post;
    }

    /**
     * @param Post $post
     * @return Post
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Post $post)
    {
        $post->setDateCreated(new \DateTime());
        $post->setDateLastUpdate(new \DateTime());

        $em = $this->getEntityManager();
        $em->persist($post);
        $em->flush();

        return $post;
    }

    /**
     * @param int $id
     * @param Post $post
     * @return Post|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(int $id, Post $post)
    {
        $currentPost = $this->find($id);

        $currentPost->setContent($post->getContent());
        $currentPost->setAuthor($post->getAuthor());
        $currentPost->setDateLastUpdate(new \DateTime());

        $em = $this->getEntityManager();
        $em->persist($currentPost);
        $em->flush();

        return $currentPost;
    }

    /**
     * @param int $id
     * @return Post
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(int $id)
    {
        $post = $this->find($id);

        if (is_null($post)) {
            throw new NotFoundHttpException("Post with id: $id not found!");
        }

        $em = $this->getEntityManager();
        $em->remove($post);
        $em->flush();

        return $post;
    }
}
