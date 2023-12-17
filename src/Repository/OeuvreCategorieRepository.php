<?php

namespace App\Repository;

use App\Entity\OeuvreCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreCategorie>
 *
 * @method OeuvreCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreCategorie[]    findAll()
 * @method OeuvreCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreCategorie::class);
    }

//    /**
//     * @return OeuvreCategorie[] Returns an array of OeuvreCategorie objects
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

//    public function findOneBySomeField($value): ?OeuvreCategorie
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
