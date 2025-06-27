<?php
namespace App\Controller\Api;

use App\Entity\Billet;
use App\Entity\Commande;
use OpenApi\Attributes as OA;
use App\Repository\VolRepository;
use App\Model\Enum\TypeBilletEnum;
use App\Model\Enum\TypePaiementEnum;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Attribute\Security as AttributeSecurity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[OA\Tag(name: 'Bookings')]
class BookingController extends AbstractController
{
    public function __construct(
        private VolRepository $volRepo,
        private EntityManagerInterface $em
    ) {}

    #[OA\Post(
        path: '/api/client/booking/{id}',
        summary: 'Réservation d’un vol',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                description: 'ID du vol',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        security: [ ['bearerAuth' => []] ],
        // responses: [
        //     new OA\Response(
        //         response: 201,
        //         description: 'Réservation créée',
        //         content: new OA\JsonContent(
        //             properties: [
        //                 new OA\Property(property: 'commandeId', type: 'integer'),
        //                 new OA\Property(property: 'billetId', type: 'integer'),
        //                 new OA\Property(property: 'price', type: 'number', format: 'float'),
        //             ]
        //         )
        //     ),
        //     new OA\Response(response: 401, description: 'Authentification requise'),
        //     new OA\Response(response: 404, description: 'Vol non trouvé')
        // ]
    )]
    #[AttributeSecurity(name: 'Bearer')]
    #[Route('/api/client/booking/{id}', name: 'api_flight_book', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function __invoke(int $id): JsonResponse
    {
        /** @var \App\Entity\CompteVoyageur $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Authentification requise'], 401);
        }
        $client = $user->getClient();
        $vol    = $this->volRepo->find($id);
        if (!$vol) {
            return $this->json(['error' => 'Vol non trouvé'], 404);
        }

        // Calcul du prix
        $price = (float) $vol->getPrixBase();
        $miles = $client->getNbMiles() ?? 0;
        if ($miles >= $price) {
            $priceEffectif = 0;
            $client->setNbMiles($miles - $price);
        } else {
            $priceEffectif = $price;
        }

        // Création de la commande
        $commande = (new Commande())
            ->setClient($client)
            ->setDateCommande(new \DateTime())
            ->setPrixTotal((string) $priceEffectif)
            ->setMoyentPaiement(TypePaiementEnum::CB)
            ->setAssuranceAnnulation(false);

        // Création du billet
        $billet = (new Billet())
            ->setClient($client)
            ->setVol($vol)
            ->setPrixEffectif((string) $priceEffectif)
            ->setClasse(TypeBilletEnum::BUSINESS)
            ->setNbBagagesSoute(0)
            ->setCommande($commande);

        $this->em->persist($commande);
        $this->em->persist($billet);
        $this->em->flush();

        return $this->json([
            'commandeId' => $commande->getId(),
            'billetId'   => $billet->getId(),
            'price'      => $priceEffectif,
        ], 201);
    }
}
