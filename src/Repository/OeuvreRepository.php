<?php

namespace App\Repository;

use App\Entity\Oeuvre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Oeuvre>
 *
 * @method Oeuvre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvre[]    findAll()
 * @method Oeuvre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvre::class);
    }

    public function countTotalArtworks()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT COUNT(*) AS `sum`
            FROM `oeuvre`;
";

        return $conn->executeQuery($sql)->fetchOne();
    }

    public function countArtworksByCategory()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT
                `ac`.`name`,
                COUNT(`o`.`artwork_category_id`) AS `sum` 
            FROM `oeuvre` AS `o`
            JOIN `artwork_category` AS `ac`
            ON `o`.`artwork_category_id` = `ac`.`id`
            GROUP BY `o`.`artwork_category_id`
            ORDER BY `ac`.`root_id`;
        ";

        return $conn->executeQuery($sql)->fetchAllAssociative();
    }

    public function countArtworksByYear()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT
                `o`.`first_year`,
                COUNT(`o`.`first_year`) AS `sum`
            FROM `oeuvre` AS `o`
            GROUP BY `o`.`first_year`
            ORDER BY `o`.`first_year` DESC;
        ";

        return $conn->executeQuery($sql)->fetchAllAssociative();
    }

//    /**
//     * @return Oeuvre[] Returns an array of Oeuvre objects
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

//    public function findOneBySomeField($value): ?Oeuvre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
