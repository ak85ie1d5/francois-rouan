<?php

namespace App\Repository;

use App\Entity\OeuvreStockage;
use App\Utils\DateChoices;
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

    public function countLastArtworksLocalisation()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT
                `l`.`nom`,
                COUNT(`os2`.`lieu_id`) AS `sum`
            FROM `oeuvre_stockage` AS `os1`
            JOIN (
                SELECT `os2`.`lieu_id`, MAX(`os2`.`oeuvre_id`) AS `max_oeuvre_id`
                FROM `oeuvre_stockage` AS `os2`
                GROUP BY `os2`.`lieu_id`
            ) AS `os2`
            ON `os1`.`lieu_id` = `os2`.`lieu_id`
            JOIN `lieu` AS `l`
            ON `l`.`id` = `os1`.`lieu_id`
            GROUP BY `os2`.`lieu_id`; 
        ";

        return $conn->executeQuery($sql)->fetchAllAssociative();
    }

    public function countLocalisationType()
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT 
                os.type AS type_id,
                 JSON_UNQUOTE(JSON_EXTRACT(o.value, CONCAT('$[', os.type, ']'))) AS type_name,
                COUNT(os.type) AS sum
            FROM oeuvre_stockage AS os
                JOIN options AS o
                    ON o.name = 'location_types'
            GROUP BY os.type;
        ";

        return $conn->executeQuery($sql)->fetchAllAssociative();
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
