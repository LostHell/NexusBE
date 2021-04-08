<?php

namespace App\Controller;

use App\Dto\Assembly\UserAssembly;
use App\Dto\Request\UserRequestDto;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @var UserAssembly
     */
    private $userAssembly;

    public function __construct(
        UserRepository $userRepository,
        ValidatorInterface $validator,
        UserAssembly $userAssembly)
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->userAssembly = $userAssembly;
    }

    /**
     * @Route("/", name="get_all", methods={"GET"})
     * @return Response
     */
    public function getAllUsers(): Response
    {
        $users = $this->userRepository->getAllUsers();
        $users = $this->userAssembly->writeManyDTOs($users);

        return $this->json(['users' => $users], 200);
    }

    /**
     * @Route("/{id}", name="get_by_id", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getUserById(int $id): Response
    {
        $user = $this->userRepository->getUserById($id);
        $user = $this->userAssembly->writeOneDTO($user);

        return $this->json(['user' => $user], 200);
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

        $newUser = $serializer->deserialize($request->getContent(), UserRequestDto::class, 'json');
        $newUser = $this->userAssembly->createUser($newUser);

        $errors = $this->validator->validate($newUser);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $user = $this->userRepository->create($newUser);
        $user = $this->userAssembly->writeOneDTO($user);

        return $this->json(['user' => $user], 201);
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

        $currentUser = $serializer->deserialize($request->getContent(), UserRequestDto::class, 'json');
        $currentUser = $this->userAssembly->readDTO($currentUser);

        $errors = $this->validator->validate($currentUser);

        if (count($errors) > 0) {
            return $this->json($errors);
        }

        $user = $this->userRepository->update($id, $currentUser);
        $user = $this->userAssembly->writeOneDTO($user);

        return $this->json(['user' => $user], 201);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->userRepository->delete($id);
        $user = $this->userAssembly->writeOneDTO($user);

        return $this->json(['user' => $user], 200);
    }
}