<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260315204028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE `artwork_media` SET `photo_credit` = 0 WHERE `artwork_media`.`caption` LIKE '%guillaume%'");
        $this->addSql("UPDATE `artwork_media` SET `photo_credit` = 0 WHERE `artwork_media`.`caption` LIKE '%vincent%'");
        $this->addSql("UPDATE `artwork_media` SET `photo_credit` = 1, `photographer_name` = 'Laurent Edeline', `caption` = '' WHERE `artwork_media`.`caption` LIKE '%edeline%'");
        $this->addSql("UPDATE `artwork_media` SET `photo_credit` = 1, `photographer_name` = 'Laurent Lecat', `caption` = '' WHERE `artwork_media`.`caption` LIKE '%lecat%'");
        $this->addSql("UPDATE `artwork_media` SET `photo_credit` = 1, `photographer_name` = 'Tanguy Beurdeley', `caption` = '' WHERE `artwork_media`.`caption` LIKE '%beurdeley%'");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
