<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240412085542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_media_test (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, modificateur_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, position INT NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, nom VARCHAR(255) NOT NULL, emplacement VARCHAR(30) DEFAULT NULL, extension VARCHAR(5) DEFAULT NULL, mime VARCHAR(30) DEFAULT NULL, taille INT DEFAULT NULL, INDEX IDX_614B6BBF73A201E5 (createur_id), INDEX IDX_614B6BBFD3DF658 (modificateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBF73A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBFD3DF658 FOREIGN KEY (modificateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBF73A201E5');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBFD3DF658');
        $this->addSql('DROP TABLE oeuvre_media_test');
    }
}
