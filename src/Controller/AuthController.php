<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class AuthController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        // Если увидишь это — json_login не перехватил запрос (значит конфиг не совпал).
        return new JsonResponse(['error' => 'json_login did not intercept'], 500);
    }
}
