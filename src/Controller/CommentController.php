<?php

namespace App\Controller;

use App\Dto\Assembly\CommentAssembly;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    public function __construct(
        CommentRepository $commentRepository,
        CommentAssembly $commentAssembly)
    {
        $this->commentRepository = $commentRepository;
        $this->commentAssembly = $commentAssembly;
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
        return $this->json(['comment' => "comment id:$id"]);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createComment(Request $request): Response
    {
        return $this->json(['comment' => "new comment - created"]);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function updateComment(int $id, Request $request): Response
    {
        return $this->json(['comment' => "comment with id: $id was updated"]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function deleteComment(int $id): Response
    {
        return $this->json(['comment' => "comment with id: $id was deleted"]);
    }
}