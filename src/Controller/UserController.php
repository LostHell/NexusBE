<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/user", name="user_")
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        UserRepository $userRepository,
        ValidatorInterface $validator)
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="get_all", methods={"GET"})
     * @return Response
     */
    public function getAllUsers(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        if (count($users) === 0) {
            throw new NotFoundHttpException();
        }

        return $this->json(['data' => $users], 200);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getUserById(int $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (is_null($user)) {
            throw new NotFoundHttpException("User with id:$id not found!");
        }

        return $this->json(['data' => $user], 200);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUser(Request $request): Response
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $newUser = $serializer->deserialize($request->getContent(), User::class, 'json');

        $errors = $this->validator->validate($newUser);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $data = $this->userRepository->create($newUser);

        return $this->json(['data' => $data], 201);
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateUser(int $id, Request $request): Response
    {
        /**
         * @var Serializer $serializer
         */
        $serializer = $this->get('serializer');

        $currentUser = $serializer->deserialize($request->getContent(), User::class, 'json');

        $errors = $this->validator->validate($currentUser);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $user = $this->userRepository->update($id, $currentUser);

        return $this->json(['data' => $user], 201);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if (is_null($user)) {
            throw new NotFoundHttpException("User with id: $id not found!");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->json(['data' => $user], 200);
    }
}