<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402125358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_stockage ADD internal_location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_stockage ADD CONSTRAINT FK_36424E043322610B FOREIGN KEY (internal_location_id) REFERENCES internal_location (id)');
        $this->addSql('CREATE INDEX IDX_36424E043322610B ON oeuvre_stockage (internal_location_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_stockage DROP FOREIGN KEY FK_36424E043322610B');
        $this->addSql('DROP INDEX IDX_36424E043322610B ON oeuvre_stockage');
        $this->addSql('ALTER TABLE oeuvre_stockage DROP internal_location_id');
    }
}
