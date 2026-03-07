<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260307210004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_media ADD photo_credit INT DEFAULT NULL, ADD photographer_name VARCHAR(40) DEFAULT NULL');
        $this->addSql("INSERT INTO `options` (`id`, `name`, `value`) VALUES (NULL, 'photo_credit', '[\"Interne\",\"Photographe\"]')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_media DROP photo_credit, DROP photographer_name');
        $this->addSql(("DELETE FROM `options` WHERE `name` = 'photo_credit'"));
    }
}
