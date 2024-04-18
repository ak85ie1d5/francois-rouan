<?php

namespace App\Repository;

use App\Entity\OeuvreMediaTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreMediaTest>
 *
 * @method OeuvreMediaTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreMediaTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreMediaTest[]    findAll()
 * @method OeuvreMediaTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreMediaTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreMediaTest::class);
    }

//    /**
//     * @return OeuvreMedia[] Returns an array of OeuvreMedia objects
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

//    public function findOneBySomeField($value): ?OeuvreMedia
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
