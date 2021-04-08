<?php

namespace App\Controller;

use App\Dto\Assembly\PostAssembly;
use App\Dto\Request\PostRequestDto;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
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
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var PostAssembly
     */
    private $postAssembly;

    public function __construct(
        PostRepository $postRepository,
        UserRepository $userRepository,
        ValidatorInterface $validator,
        PostAssembly $postAssembly)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->postAssembly = $postAssembly;
    }

    /**
     * @Route("/", name="get_all", methods={"GET"})
     * @return Response
     */
    public function getAllPosts(): Response
    {
        $posts = $this->postRepository->getAllPosts();
        $posts = $this->postAssembly->writeManyDTOs($posts);

        return $this->json(['posts' => $posts], 200);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getPostById(int $id): Response
    {
        $post = $this->postRepository->getPostById($id);
        $post = $this->postAssembly->writeOneDTO($post);

        return $this->json(['post' => $post], 200);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createPost(Request $request): Response
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $newPost = $serializer->deserialize($request->getContent(), PostRequestDto::class, 'json');

        $user = $this->userRepository->getUserById($newPost->getAuthorId());

        $newPost = $this->postAssembly->readDTO($newPost, null, $user);

        $errors = $this->validator->validate($newPost);

        if (count($errors)) {
            return $this->json($errors);
        }

        $post = $this->postRepository->create($newPost);
        $post = $this->postAssembly->writeOneDTO($post);

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

        $currentPost = $serializer->deserialize($request->getContent(), PostRequestDto::class, 'json');

        $user = $this->userRepository->getUserById($currentPost->getAuthorId());
        $post = $this->postRepository->getPostById($id);

        $currentPost = $this->postAssembly->readDTO($currentPost, $post, $user);

        $errors = $this->validator->validate($currentPost);

        if (count($errors)) {
            return $this->json($errors);
        }

        $post = $this->postRepository->update($id, $currentPost);
        $post = $this->postAssembly->writeOneDTO($post);

        return $this->json(['post' => $post], 201);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deletePost(int $id): Response
    {
        $post = $this->postRepository->delete($id);
        $post = $this->postAssembly->writeOneDTO($post);

        return $this->json(['post' => $post], 200);
    }
}