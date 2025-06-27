<?php

namespace App\Controller\Api;

use DateTime;
use App\Entity\Client;
use OpenApi\Attributes as OA;
use App\Entity\CompteVoyageur;
use App\Model\Enum\TypeDocVoyageEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class RegisterController extends AbstractController
{

    #[OA\Post(
        summary: 'Register a new client',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nom', 'prenom', 'email', 'dateNaissance', 'numDocVoyage', 'typeDocVoyage', 'password'],
                properties: [
                    new OA\Property(property: 'nom', type: 'string'),
                    new OA\Property(property: 'prenom', type: 'string'),
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'dateNaissance', type: 'string', format: 'date'),
                    new OA\Property(property: 'numDocVoyage', type: 'string'),
                    new OA\Property(property: 'typeDocVoyage', type: 'string'),
                    new OA\Property(property: 'password', type: 'string')
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Client registered successfully'),
            new OA\Response(response: 400, description: 'Bad Request - Missing required fields'),
            new OA\Response(response: 409, description: 'Conflict - Email already exists')
        ]
    )]
    #[Route('/api/client/register', name: 'api_client_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        $email = $data['email'] ?? null;
        $dateNaissance = $data['dateNaissance'] ?? null;
        $numDocVoyage = $data['numDocVoyage'] ?? null;
        $typeDocVoyage = $data['typeDocVoyage'] ?? null;
        $password = $data['password'] ?? null;

        if (!$nom || !$prenom || !$email || !$dateNaissance || !$numDocVoyage || !$typeDocVoyage || !$password) {
            return $this->json(['error' => 'Champs requis manquants.'], 400);
        }

        // Vérifie unicité sur l'email côté client
        if ($em->getRepository(Client::class)->findOneBy(['email' => $email])) {
            return $this->json(['error' => 'Un compte avec cet email existe déjà.'], 409);
        }

        // Création du Client
        $client = new Client();
        $client->setNom($nom);
        $client->setPrenom($prenom);
        $client->setEmail($email);
        $client->setDateNaissance(new DateTime($dateNaissance));
        $client->setNumDocVoyage($numDocVoyage);
        $client->setTypeDocVoyage(TypeDocVoyageEnum::from($typeDocVoyage));
        $client->setNbMiles(1);

        // Création du CompteVoyageur
        $compte = new CompteVoyageur();
        $compte->setLogin($email); // Login = email
        $compte->setPassword($hasher->hashPassword($compte, $password));
        $compte->setRoles(['ROLE_CLIENT']);
        $compte->setDateCreation(new DateTime());
        $compte->setClient($client);

        $em->persist($client);
        $em->persist($compte);
        $em->flush();

        $token = $jwtManager->create($compte);

        return $this->json([
            'token' => $token,
            'user' => $compte->getLogin(),
            'roles' => $compte->getRoles()
        ], 201);
    }
}
