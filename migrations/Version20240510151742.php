<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510151742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP date, DROP date_complement, DROP nb_medias, DROP date_creation, DROP date_modification, DROP createur, DROP modificateur, DROP media');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre ADD date DATE DEFAULT NULL, ADD date_complement VARCHAR(255) DEFAULT NULL, ADD nb_medias INT NOT NULL, ADD date_creation DATETIME NOT NULL, ADD date_modification DATETIME DEFAULT NULL, ADD createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD media LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }
}
