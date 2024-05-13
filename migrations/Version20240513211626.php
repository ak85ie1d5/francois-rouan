<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513211626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59B03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_2F577D59B03A8386 ON lieu (created_by_id)');
        $this->addSql('CREATE INDEX IDX_2F577D59896DBBDE ON lieu (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59B03A8386');
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59896DBBDE');
        $this->addSql('DROP INDEX IDX_2F577D59B03A8386 ON lieu');
        $this->addSql('DROP INDEX IDX_2F577D59896DBBDE ON lieu');
        $this->addSql('ALTER TABLE lieu DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
