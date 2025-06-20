<?php

namespace App\Controller\Api;

use App\Entity\CompteVoyageur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    #[Route('/api/client/register', name: 'api_client_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $login = $data['login'] ?? null;
        $password = $data['password'] ?? null;

        if (!$login || !$password) {
            return $this->json(['error' => 'Missing login or password'], 400);
        }

        $user = new CompteVoyageur();
        $user->setLogin($login);
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setRoles(['ROLE_CLIENT']);

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Client créé avec succès'], 201);
    }
}
