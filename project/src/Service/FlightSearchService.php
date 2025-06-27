<?php
// src/Service/FlightSearchService.php
namespace App\Service;

use DateTimeInterface;
use App\Entity\Escales;
use App\Repository\VolRepository;

class FlightSearchService
{
    public function __construct(private VolRepository $volRepo) {}

    /**
     * Recherche les vols directs et indirects (1 escale max) entre deux villes.
     *
     * @param string $from Code de la ville de départ (VillesDestinationEnum)
     * @param string $to   Code de la ville d’arrivée (VillesDestinationEnum)
     * @return array       Tableau de résultats, chaque élément contenant :
     *                     - legs: Vol[]         (1 ou 2 segments)
     *                     - price: float       Prix total
     *                     - flight_time: string Durée de vol (hors escale)
     *                     - total_time: string  Durée totale (avec escale)
     *                     - escales: string[]   Liste des villes d’escale
     */
    public function search(string $from, string $to): array
    {
        // vols directs
        $directs = $this->volRepo->findDirectFlights($from, $to);
        // vols indirects (1 escale)
        $indirects = $this->volRepo->findIndirectFlights($from, $to);

        $formatDuration = function(DateTimeInterface $start, DateTimeInterface $end): string {
            $diff = $end->diff($start);
            return sprintf('%dh %02dmin', $diff->h, $diff->i);
        };

        $results = [];

        // traiter les directs
        foreach ($directs as $vol) {
            $flightTime = $formatDuration($vol->getDateDepart(), $vol->getDateArrivee());
            $results[] = [
                'legs'        => [$vol],
                'price'       => (float) $vol->getPrixBase(),
                'flight_time' => $flightTime,
                'total_time'  => $flightTime,
                'escales'     => $vol->getEscales()->isEmpty() ? [] : array(
                    fn(Escales $escale) => $escale->getVilleEscale()->value
                ),
            ];
        }

        // traiter les indirects
        foreach ($indirects as $vol) {
            $escaleCities = [];
            foreach ($vol->getEscales() as $escale) {
                $escaleCities[] = $escale->getVilleEscale()->value;
            }

            $flightTime = $formatDuration($vol->getDateDepart(), $vol->getDateArrivee());

            $results[] = [
                'legs'        => [$vol], // Un seul Vol, qui contient des escales
                'price'       => (float) $vol->getPrixBase(),
                'flight_time' => $flightTime,
                'total_time'  => $flightTime,
                'escales'     => $escaleCities,
            ];
        }


        return $results;
    }
}
 