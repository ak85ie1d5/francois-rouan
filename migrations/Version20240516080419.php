<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516080419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_exposition ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD first_day INT DEFAULT NULL, ADD first_month INT DEFAULT NULL, ADD first_year INT NOT NULL');
        $this->addSql('ALTER TABLE oeuvre_exposition ADD CONSTRAINT FK_C6423773B03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_exposition ADD CONSTRAINT FK_C6423773896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_C6423773B03A8386 ON oeuvre_exposition (created_by_id)');
        $this->addSql('CREATE INDEX IDX_C6423773896DBBDE ON oeuvre_exposition (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_exposition DROP FOREIGN KEY FK_C6423773B03A8386');
        $this->addSql('ALTER TABLE oeuvre_exposition DROP FOREIGN KEY FK_C6423773896DBBDE');
        $this->addSql('DROP INDEX IDX_C6423773B03A8386 ON oeuvre_exposition');
        $this->addSql('DROP INDEX IDX_C6423773896DBBDE ON oeuvre_exposition');
        $this->addSql('ALTER TABLE oeuvre_exposition DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP first_day, DROP first_month, DROP first_year');
    }
}
