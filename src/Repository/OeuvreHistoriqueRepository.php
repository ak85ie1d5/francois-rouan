<?php

namespace App\Repository;

use App\Entity\OeuvreHistorique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreHistorique>
 *
 * @method OeuvreHistorique|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreHistorique|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreHistorique[]    findAll()
 * @method OeuvreHistorique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreHistoriqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreHistorique::class);
    }

//    /**
//     * @return OeuvreHistorique[] Returns an array of OeuvreHistorique objects
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

//    public function findOneBySomeField($value): ?OeuvreHistorique
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
