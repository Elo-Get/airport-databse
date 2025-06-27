<?php
namespace App\Controller\Api;

use OpenApi\Attributes as OA;
use App\Repository\VolRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[OA\Tag(name: 'Client')]
class FlightController extends AbstractController
{
    public function __construct(private VolRepository $repo) {}

    #[OA\Get(
        path: '/api/client/flights/{id}',
        summary: 'Détails d’un vol',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID du vol',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        // responses: [
        //     new OA\Response(
        //         response: 200,
        //         description: 'Détails du vol',
        //         content: new OA\JsonContent(ref: '#/components/schemas/Vol')
        //     ),
        //     new OA\Response(response: 404, description: 'Vol non trouvé')
        // ]
    )]
    #[Route('/api/client/flights/{id}', name: 'api_flight_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function __invoke(int $id): JsonResponse
    {
        $vol = $this->repo->find($id);
        if (!$vol) {
            return $this->json(['error' => 'Vol non trouvé'], 404);
        }

        return $this->json($vol, 200, [], ['groups' => ['details']]);
    }
}
