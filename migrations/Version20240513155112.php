<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513155112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_historique ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_historique ADD CONSTRAINT FK_97CC1F8CB03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_historique ADD CONSTRAINT FK_97CC1F8C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_97CC1F8CB03A8386 ON oeuvre_historique (created_by_id)');
        $this->addSql('CREATE INDEX IDX_97CC1F8C896DBBDE ON oeuvre_historique (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_historique DROP FOREIGN KEY FK_97CC1F8CB03A8386');
        $this->addSql('ALTER TABLE oeuvre_historique DROP FOREIGN KEY FK_97CC1F8C896DBBDE');
        $this->addSql('DROP INDEX IDX_97CC1F8CB03A8386 ON oeuvre_historique');
        $this->addSql('DROP INDEX IDX_97CC1F8C896DBBDE ON oeuvre_historique');
        $this->addSql('ALTER TABLE oeuvre_historique DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
