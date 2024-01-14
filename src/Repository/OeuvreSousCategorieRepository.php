<?php

namespace App\Repository;

use App\Entity\OeuvreSousCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreSousCategorie>
 *
 * @method OeuvreSousCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreSousCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreSousCategorie[]    findAll()
 * @method OeuvreSousCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreSousCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreSousCategorie::class);
    }

//    /**
//     * @return OeuvreSousCategorie[] Returns an array of OeuvreSousCategorie objects
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

//    public function findOneBySomeField($value): ?OeuvreSousCategorie
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
