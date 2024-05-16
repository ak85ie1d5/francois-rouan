<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516080649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_exposition DROP date_debut, DROP date_fin, DROP date_creation, DROP date_modification, DROP createur, DROP modificateur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_exposition ADD date_debut DATETIME NOT NULL, ADD date_fin DATETIME DEFAULT NULL, ADD date_creation DATETIME NOT NULL, ADD date_modification DATETIME DEFAULT NULL, ADD createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
