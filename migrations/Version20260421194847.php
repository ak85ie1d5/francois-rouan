<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260421194847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE `oeuvre_stockage` SET `description` = `commentaire`');
        $this->addSql('ALTER TABLE `oeuvre_stockage` DROP COLUMN `commentaire`');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `oeuvre_stockage` ADD COLUMN `commentaire` LONGTEXT DEFAULT NULL');
    }
}
