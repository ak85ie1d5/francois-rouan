<?php

namespace App\Repository;

use App\Entity\ArtworkCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArtworkCategory>
 *
 * @method ArtworkCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtworkCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtworkCategory[]    findAll()
 * @method ArtworkCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtworkCategory::class);
    }

    //    /**
    //     * @return ArtworkCategory[] Returns an array of ArtworkCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ArtworkCategory
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
