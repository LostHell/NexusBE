<?php

namespace App\Controller;

use App\Dto\Request\PostRequestDto;
use App\Dto\Request\UserRequestDto;
use App\Dto\Response\PostResponseDto;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use AutoMapperPlus\AutoMapperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/post", name="post_")
 * Class PostController
 * @package App\Controller
 */
class PostController extends AbstractController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var AutoMapperInterface
     */
    private $mapper;

    public function __construct(
        PostRepository $postRepository,
        ValidatorInterface $validator,
        AutoMapperInterface $mapper)
    {
        $this->postRepository = $postRepository;
        $this->validator = $validator;
        $this->mapper = $mapper;
    }

    /**
     * @Route("/", name="get_all", methods={"GET"})
     * @return Response
     */
    public function getAllPosts(): Response
    {
        $posts = $this->postRepository->getAllPosts();
        $posts = $this->mapper->mapMultiple($posts, PostResponseDto::class);

        return $this->json(['posts' => $posts], 200);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function getPostById(int $id): Response
    {
        $post = $this->postRepository->getPostById($id);
        $post = $this->mapper->map($post, PostResponseDto::class);

        return $this->json(['post' => $post], 200);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function createPost(Request $request): Response
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $post = $serializer->deserialize($request->getContent(), UserRequestDto::class, 'json');
        $post = $this->mapper->map($post, User::class);

//        $errors = $this->validator->validate($post);
//
//        if (count($errors)) {
//            return $this->json($errors);
//        }
//
//        $data = $this->postRepository->create($post);

        return $this->json(['post' => $post], 201);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updatePost(int $id, Request $request): Response
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $post = $serializer->deserialize($request->getContent(), Post::class, 'json');

        $errors = $this->validator->validate($post);

        if (count($errors)) {
            return $this->json($errors);
        }

        $data = $this->postRepository->update($id, $post);

        return $this->json(['post' => $data], 201);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function deletePost(int $id): Response
    {
        $post = $this->postRepository->delete($id);
        $post = $this->mapper->map($post, PostResponseDto::class);

        return $this->json(['post' => $post], 200);
    }
}