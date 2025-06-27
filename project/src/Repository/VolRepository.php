<?php

namespace App\Repository;

use App\Entity\Vol;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Vol>
 */
class VolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vol::class);
    }

    public function findDirectFlights(string $fromCity, string $toCity): array
    {
        $qb = $this->createQueryBuilder('v')
            ->join('v.aeroportDepart', 'ad')
            ->join('v.aeroportArrive', 'aa')
            ->where('ad.ville = :fromCity')
            ->andWhere('aa.ville = :toCity')
            ->setParameter('fromCity', $fromCity)
            ->setParameter('toCity', $toCity);

        return $qb->getQuery()->getResult();
    }

    public function findIndirectFlights(string $fromCity, string $toCity): array
    {
        return $this->createQueryBuilder('v')
            ->join('v.aeroportDepart', 'ad')
            ->join('v.aeroportArrive', 'aa')
            ->join('v.escales', 'e')
            ->where('ad.ville = :fromCity')
            ->andWhere('aa.ville = :toCity')
            ->setParameter('fromCity', $fromCity)
            ->setParameter('toCity', $toCity)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Vol[] Returns an array of Vol objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vol
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
