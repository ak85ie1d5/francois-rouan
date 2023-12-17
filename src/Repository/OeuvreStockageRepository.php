<?php

namespace App\Repository;

use App\Entity\OeuvreStockage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreStockage>
 *
 * @method OeuvreStockage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreStockage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreStockage[]    findAll()
 * @method OeuvreStockage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreStockageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreStockage::class);
    }

//    /**
//     * @return OeuvreStockage[] Returns an array of OeuvreStockage objects
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

//    public function findOneBySomeField($value): ?OeuvreStockage
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
