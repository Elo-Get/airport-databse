<?php 

namespace App\Controller\Api;

use App\Entity\Vol;
use OpenApi\Attributes as OA;
use App\Repository\VolRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/gerant')]
class VolController extends AbstractController
{
    #[Route('/passagers-par-vol', name: 'api_gerant_passagers_par_vol', methods: ['GET'])]
    #[IsGranted('ROLE_GERANT')]
    #[OA\Get(
        path: '/api/gerant/passagers-par-vol',
        summary: 'Nombre de passagers par vol',
        description: 'Accessible uniquement aux gérants. Retourne la liste des vols avec le nombre de passagers pour chacun.',
    )]
    public function passagersParVol(VolRepository $volRepo): JsonResponse
    {
        $vols = $volRepo->findAll();

        $data = [];

        foreach ($vols as $vol) {
            $data[] = [
                'vol_id'       => $vol->getId(),
                'depart'       => $vol->getAeroportDepart()?->getVille()?->value,
                'arrivee'      => $vol->getAeroportArrive()?->getVille()?->value,
                'date'         => $vol->getDateDepart()->format('Y-m-d H:i'),
                'nb_passagers' => $vol->getBillets()->count(), // ou getReservations() selon ton modèle
            ];
        }

        return $this->json($data);
    }
}
