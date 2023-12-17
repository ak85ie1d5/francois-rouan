<?php

namespace App\Repository;

use App\Entity\OeuvreBibliographie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreBibliographie>
 *
 * @method OeuvreBibliographie|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreBibliographie|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreBibliographie[]    findAll()
 * @method OeuvreBibliographie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreBibliographieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreBibliographie::class);
    }

//    /**
//     * @return OeuvreBibliographie[] Returns an array of OeuvreBibliographie objects
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

//    public function findOneBySomeField($value): ?OeuvreBibliographie
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
