<?php

namespace App\Controller;

use App\Dto\Assembly\CommentAssembly;
use App\Dto\Request\CommentRequestDto;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/comment", name="comment_")
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends AbstractController
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var CommentAssembly
     */
    private $commentAssembly;

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

    public function __construct(
        CommentRepository $commentRepository,
        CommentAssembly $commentAssembly,
        PostRepository $postRepository,
        UserRepository $userRepository,
        ValidatorInterface $validator)
    {
        $this->commentRepository = $commentRepository;
        $this->commentAssembly = $commentAssembly;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="get_all", methods={"GET"})
     * @return Response
     */
    public function getAllComments(): Response
    {
        $comments = $this->commentRepository->getAllComments();
        $comments = $this->commentAssembly->writeManyDTOs($comments);

        return $this->json(['comments' => $comments], 200);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getCommentById(int $id): Response
    {
        $comment = $this->commentRepository->getCommentById($id);
        $comment = $this->commentAssembly->writeOneDTO($comment);

        return $this->json(['comment' => $comment]);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createComment(Request $request): Response
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $newComment = $serializer->deserialize($request->getContent(), CommentRequestDto::class, 'json');

        $post = $this->postRepository->getPostById($newComment->getPostId());
        $user = $this->userRepository->getUserById($newComment->getAuthorId());

        $newComment = $this->commentAssembly->readDTO($newComment, null, $post, $user);

        $errors = $this->validator->validate($newComment);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $comment = $this->commentRepository->create($newComment);

        $comment = $this->commentAssembly->writeOneDTO($comment);

        return $this->json(['comment' => $comment]);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateComment(int $id, Request $request): Response
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $currentComment = $serializer->deserialize($request->getContent(), CommentRequestDto::class, 'json');

        $currentComment = $this->commentAssembly->readDTO($currentComment);

        $errors = $this->validator->validate($currentComment);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $comment = $this->commentRepository->update($id, $currentComment);

        $comment = $this->commentAssembly->writeOneDTO($comment);

        return $this->json(['comment' => $comment]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteComment(int $id): Response
    {
        $comment = $this->commentRepository->delete($id);
        $comment = $this->commentAssembly->writeOneDTO($comment);

        return $this->json(['comment' => $comment]);
    }
}