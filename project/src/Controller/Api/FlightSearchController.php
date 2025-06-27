<?php
namespace App\Controller\Api;

use OpenApi\Attributes as OA;
use App\Service\FlightSearchService;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FlightSearchController extends AbstractController
{
    public function __construct(private FlightSearchService $searchService) {}

    #[OA\Get(
        path: '/api/client/flights/search',
        summary: 'Recherche de vols',
        parameters: [
            new OA\Parameter(
                name: 'from',
                in: 'query',
                description: 'Ville de départ (enum VillesDestinationEnum)',
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'to',
                in: 'query',
                description: 'Ville d’arrivée (enum VillesDestinationEnum)',
                schema: new OA\Schema(type: 'string')
            ),
        ],
        // responses: [
        //     new OA\Response(
        //         response: 200,
        //         description: 'Liste des vols',
        //         content: new OA\JsonContent(
        //             type: 'array',
        //             items: new OA\Items(
        //                 type: 'object',
        //                 properties: [
        //                     new OA\Property(property: 'legs', type: 'array', items: new OA\Items(ref: '#/components/schemas/Vol')),
        //                     new OA\Property(property: 'price', type: 'number', format: 'float'),
        //                     new OA\Property(property: 'flight_time', type: 'string'),
        //                     new OA\Property(property: 'total_time', type: 'string'),
        //                     new OA\Property(property: 'escales', type: 'array', items: new OA\Items(type: 'string')),
        //                 ]
        //             )
        //         )
        //     ),
        //     new OA\Response(response: 400, description: 'Paramètres manquants')
        // ]
    )]
    #[Route('/api/client/flights/search', name: 'api_flight_search', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {

        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Not authenticated'], 401);
        }


        $from = $request->query->get('from');
        $to   = $request->query->get('to');

        if (!$from || !$to) {
            return $this->json(['error' => 'Les paramètres "from" et "to" sont obligatoires.'], 400);
        }

        $results = $this->searchService->search($from, $to);
        return $this->json($results, 200, [], ['groups' => ['default']]);
    }
}
