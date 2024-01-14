<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240113210039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_categorie_oeuvre_categorie (oeuvre_categorie_source INT NOT NULL, oeuvre_categorie_target INT NOT NULL, INDEX IDX_ADC9FC4D5211C89E (oeuvre_categorie_source), INDEX IDX_ADC9FC4D4BF49811 (oeuvre_categorie_target), PRIMARY KEY(oeuvre_categorie_source, oeuvre_categorie_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre_media (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, position INT NOT NULL, createur INT NOT NULL, modificateur INT DEFAULT NULL, date_creation VARCHAR(255) NOT NULL, date_modification VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, emplacement VARCHAR(255) NOT NULL, extension VARCHAR(10) NOT NULL, mime VARCHAR(15) NOT NULL, taille INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie ADD CONSTRAINT FK_ADC9FC4D5211C89E FOREIGN KEY (oeuvre_categorie_source) REFERENCES oeuvre_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie ADD CONSTRAINT FK_ADC9FC4D4BF49811 FOREIGN KEY (oeuvre_categorie_target) REFERENCES oeuvre_categorie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE groupe_utilisateur');
        $this->addSql('ALTER TABLE oeuvre_categorie DROP sous_categories');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_utilisateur (groupe_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_92C1107D7A45358C (groupe_id), INDEX IDX_92C1107DFB88E14F (utilisateur_id), PRIMARY KEY(groupe_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie DROP FOREIGN KEY FK_ADC9FC4D5211C89E');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie DROP FOREIGN KEY FK_ADC9FC4D4BF49811');
        $this->addSql('DROP TABLE oeuvre_categorie_oeuvre_categorie');
        $this->addSql('DROP TABLE oeuvre_media');
        $this->addSql('ALTER TABLE oeuvre_categorie ADD sous_categories LONGTEXT NOT NULL COMMENT \'(DC2Type:json_document)\'');
    }
}
