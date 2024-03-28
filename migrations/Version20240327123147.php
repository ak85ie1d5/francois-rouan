<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327123147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_media (oeuvre_id INT NOT NULL, media_id BINARY(16) NOT NULL COMMENT \'(DC2Type:media_id)\', INDEX IDX_F564E27388194DE8 (oeuvre_id), INDEX IDX_F564E273EA9FDD75 (media_id), PRIMARY KEY(oeuvre_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvre_media ADD CONSTRAINT FK_F564E27388194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_media ADD CONSTRAINT FK_F564E273EA9FDD75 FOREIGN KEY (media_id) REFERENCES ranky_media (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media DROP FOREIGN KEY FK_F564E27388194DE8');
        $this->addSql('ALTER TABLE oeuvre_media DROP FOREIGN KEY FK_F564E273EA9FDD75');
        $this->addSql('DROP TABLE oeuvre_media');
    }
}
