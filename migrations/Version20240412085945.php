<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412085945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test ADD oeuvre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBF88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('CREATE INDEX IDX_614B6BBF88194DE8 ON oeuvre_media_test (oeuvre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBF88194DE8');
        $this->addSql('DROP INDEX IDX_614B6BBF88194DE8 ON oeuvre_media_test');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP oeuvre_id');
    }
}
