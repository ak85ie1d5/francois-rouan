<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513202926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_bibliographie DROP date, DROP date_creation, DROP date_modification, DROP createur, DROP modificateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_bibliographie ADD date DATETIME DEFAULT NULL, ADD date_creation DATETIME NOT NULL, ADD date_modification DATETIME DEFAULT NULL, ADD createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
