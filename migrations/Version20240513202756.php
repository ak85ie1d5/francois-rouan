<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513202756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_bibliographie ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_bibliographie ADD CONSTRAINT FK_56331A98B03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_bibliographie ADD CONSTRAINT FK_56331A98896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_56331A98B03A8386 ON oeuvre_bibliographie (created_by_id)');
        $this->addSql('CREATE INDEX IDX_56331A98896DBBDE ON oeuvre_bibliographie (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_bibliographie DROP FOREIGN KEY FK_56331A98B03A8386');
        $this->addSql('ALTER TABLE oeuvre_bibliographie DROP FOREIGN KEY FK_56331A98896DBBDE');
        $this->addSql('DROP INDEX IDX_56331A98B03A8386 ON oeuvre_bibliographie');
        $this->addSql('DROP INDEX IDX_56331A98896DBBDE ON oeuvre_bibliographie');
        $this->addSql('ALTER TABLE oeuvre_bibliographie DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
