<?php

namespace App\Repository;

use App\Entity\ArtworkMedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArtworkMedia>
 *
 * @method ArtworkMedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtworkMedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtworkMedia[]    findAll()
 * @method ArtworkMedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkMediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtworkMedia::class);
    }

//    /**
//     * @return ArtworkMedia[] Returns an array of ArtworkMedia objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ArtworkMedia
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
