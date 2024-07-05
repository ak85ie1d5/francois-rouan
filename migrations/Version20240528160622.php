<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528160622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBFB03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBF896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_614B6BBFB03A8386 ON oeuvre_media_test (created_by_id)');
        $this->addSql('CREATE INDEX IDX_614B6BBF896DBBDE ON oeuvre_media_test (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBFB03A8386');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBF896DBBDE');
        $this->addSql('DROP INDEX IDX_614B6BBFB03A8386 ON oeuvre_media_test');
        $this->addSql('DROP INDEX IDX_614B6BBF896DBBDE ON oeuvre_media_test');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
