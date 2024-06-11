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

    public function getLastLocalisation(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT
                `l`.`nom`
            FROM `oeuvre` AS `o`
                JOIN `oeuvre_stockage` AS `os`
                    ON `os`.`oeuvre_id` = `o`.`id`
                JOIN `lieu` AS `l`
                    ON `os`.`lieu_id` = `l`.`id`
            WHERE `o`.`id` = :id
            ORDER BY `l`.`id`
            DESC LIMIT 1; 
        ";

        return $conn->executeQuery($sql, ['id' => $id])->fetchAssociative();
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
    IFNULL(parent_ac.`name`, ac.`name`) AS `category_name`,
    COUNT(DISTINCT o.`id`) AS `artwork_count`
FROM `oeuvre` AS `o`
JOIN `artwork_category` AS `ac`
    ON `o`.`artwork_category_id` = `ac`.`id`
LEFT JOIN `artwork_category` AS `parent_ac`
    ON `ac`.`parent_id` = `parent_ac`.`id`
GROUP BY `category_name`
ORDER BY `category_name`;
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
