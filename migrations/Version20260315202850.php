<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260315202850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Catalogue Brigitte Courme' WHERE `artwork_category`.`id` = 1");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Dessin' WHERE `artwork_category`.`id` = 2");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Film' WHERE `artwork_category`.`id` = 3");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Peinture' WHERE `artwork_category`.`id` = 4");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Photo' WHERE `artwork_category`.`id` = 5");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Tapisserie' WHERE `artwork_category`.`id` = 8");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur papier' WHERE `artwork_category`.`id` = 9");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur papier tressé' WHERE `artwork_category`.`id` = 10");
        $this->addSql("UPDATE `artwork_category` SET `name` = '35 mm' WHERE `artwork_category`.`id` = 11");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur papier' WHERE `artwork_category`.`id` = 12");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur papier tressé' WHERE `artwork_category`.`id` = 13");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur toile' WHERE `artwork_category`.`id` = 14");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur toile tressée' WHERE `artwork_category`.`id` = 15");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Tirage argentique' WHERE `artwork_category`.`id` = 16");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Tirage numérique' WHERE `artwork_category`.`id` = 17");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'Gravure' WHERE `artwork_category`.`id` = 18");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur support photo' WHERE `artwork_category`.`id` = 19");
        $this->addSql("UPDATE `artwork_category` SET `name` = 'sur support photo tressé' WHERE `artwork_category`.`id` = 21");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 1");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 2");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 3");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 4");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 5");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 8");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 9");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 10");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 11");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 12");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 13");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 14");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 15");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 16");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 17");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 18");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 19");
        $this->addSql("UPDATE `artwork_category` SET `name` = '' WHERE `artwork_category`.`id` = 21");
    }
}
