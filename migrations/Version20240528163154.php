<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528163154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artwork_media (id INT AUTO_INCREMENT NOT NULL, oeuvre_id INT DEFAULT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, position INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, mime VARCHAR(30) DEFAULT NULL, taille INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_FBC6C91688194DE8 (oeuvre_id), INDEX IDX_FBC6C916B03A8386 (created_by_id), INDEX IDX_FBC6C916896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artwork_media ADD CONSTRAINT FK_FBC6C91688194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE artwork_media ADD CONSTRAINT FK_FBC6C916B03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE artwork_media ADD CONSTRAINT FK_FBC6C916896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBF88194DE8');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBF896DBBDE');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBFB03A8386');
        $this->addSql('DROP TABLE oeuvre_media_test');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_media_test (id INT AUTO_INCREMENT NOT NULL, oeuvre_id INT DEFAULT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, libelle VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, position INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, mime VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, taille INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_614B6BBF88194DE8 (oeuvre_id), INDEX IDX_614B6BBFB03A8386 (created_by_id), INDEX IDX_614B6BBF896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBF88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBF896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBFB03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE artwork_media DROP FOREIGN KEY FK_FBC6C91688194DE8');
        $this->addSql('ALTER TABLE artwork_media DROP FOREIGN KEY FK_FBC6C916B03A8386');
        $this->addSql('ALTER TABLE artwork_media DROP FOREIGN KEY FK_FBC6C916896DBBDE');
        $this->addSql('DROP TABLE artwork_media');
    }
}
