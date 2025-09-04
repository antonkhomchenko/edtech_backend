<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class UserController extends AbstractController
{
    #[Route('/api/currentUser', name: 'api_current_user', methods: ['GET'])]
    public function getCurrentUser(): JsonResponse
    {
        /** @var User|null $currentUser */
        $currentUser = $this->getUser();
        if (!$currentUser) {
            throw $this->createAccessDeniedException();
        }

        return new JsonResponse([
            'id' => $currentUser->getId(),
            'email' => $currentUser->getEmail(),
            'firstName' => $currentUser->getFirstName(),
            'lastName' => $currentUser->getLastName(),
            'title' => $currentUser->getTitle(),
            'description' => $currentUser->getDescription(),
        ]);
    }
}
