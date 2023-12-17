<?php

namespace App\Repository;

use App\Entity\GroupeOeuvreCategoriePerm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupeOeuvreCategoriePerm>
 *
 * @method GroupeOeuvreCategoriePerm|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeOeuvreCategoriePerm|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeOeuvreCategoriePerm[]    findAll()
 * @method GroupeOeuvreCategoriePerm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeOeuvreCategoriePermRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeOeuvreCategoriePerm::class);
    }

//    /**
//     * @return GroupeOeuvreCategoriePerm[] Returns an array of GroupeOeuvreCategoriePerm objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GroupeOeuvreCategoriePerm
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
