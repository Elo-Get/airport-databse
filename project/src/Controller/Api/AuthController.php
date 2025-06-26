<?php

namespace App\Controller\Api;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @OA\Info(title="API Authentification", version="1.0")
 */

class AuthController extends AbstractController
{
    #[Route('/api/client/login', name: 'api_client_login', methods: ['POST'])]
    #[OA\Post(
        summary: 'Login client',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['login', 'password'],
                properties: [
                    new OA\Property(property: 'login', type: 'string'),
                    new OA\Property(property: 'password', type: 'string')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Connexion réussie'),
            new OA\Response(response: 401, description: 'Échec de connexion')
        ]
    )]
    public function loginClient(): JsonResponse
    {
        // Symfony gère automatiquement l'authentification via json_login
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['message' => 'Échec de la connexion'], 401);
        }
        return $this->json(['message' => 'Client connecté avec succès', 'user' => $user?->getUserIdentifier()]);
    }

    #[Route('/api/gerant/login', name: 'api_gerant_login', methods: ['POST'])]
    #[OA\Post(
        summary: 'Login gérant',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'password', type: 'string')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Connexion réussie'),
            new OA\Response(response: 401, description: 'Échec de connexion')
        ]
    )]
    public function loginGerant(): JsonResponse
    {
        // Symfony gère automatiquement l'authentification via json_login
        $user = $this->getUser();
        return $this->json(['message' => 'Gérant connecté avec succès', 'user' => $user?->getUserIdentifier()]);
    }


    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    #[OA\Get(
        summary: 'Obtenir les informations de l’utilisateur connecté',
        responses: [
            new OA\Response(response: 200, description: 'Informations de l’utilisateur'),
            new OA\Response(response: 401, description: 'Non autorisé')
        ]
    )]
    public function me(TokenStorageInterface $tokenStorage,  Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Not authenticated'], 401);
        }

        return new JsonResponse([
            'user' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'class' => get_class($user),
        ]);
    }
}