<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429145231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFEBCF5E72D');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm DROP FOREIGN KEY FK_28699DB7A45358C');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm DROP FOREIGN KEY FK_28699DBBCF5E72D');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie DROP FOREIGN KEY FK_ADC9FC4D4BF49811');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie DROP FOREIGN KEY FK_ADC9FC4D5211C89E');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AAFB88E14F');
        $this->addSql('DROP TABLE oeuvre_categorie');
        $this->addSql('DROP TABLE groupe_oeuvre_categorie_perm');
        $this->addSql('DROP TABLE oeuvre_categorie_oeuvre_categorie');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE utilisateur_groupe');
        $this->addSql('DROP INDEX IDX_35FE2EFEBCF5E72D ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre DROP categorie_id, DROP sous_categorie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, commentaire LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', modificateur LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE groupe_oeuvre_categorie_perm (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_28699DBBCF5E72D (categorie_id), INDEX IDX_28699DB7A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE oeuvre_categorie_oeuvre_categorie (oeuvre_categorie_source INT NOT NULL, oeuvre_categorie_target INT NOT NULL, INDEX IDX_ADC9FC4D5211C89E (oeuvre_categorie_source), INDEX IDX_ADC9FC4D4BF49811 (oeuvre_categorie_target), PRIMARY KEY(oeuvre_categorie_source, oeuvre_categorie_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, commentaire LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, createur LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', modificateur LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', date_modification DATETIME DEFAULT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur_groupe (utilisateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_6514B6AAFB88E14F (utilisateur_id), INDEX IDX_6514B6AA7A45358C (groupe_id), PRIMARY KEY(utilisateur_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm ADD CONSTRAINT FK_28699DB7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm ADD CONSTRAINT FK_28699DBBCF5E72D FOREIGN KEY (categorie_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie ADD CONSTRAINT FK_ADC9FC4D4BF49811 FOREIGN KEY (oeuvre_categorie_target) REFERENCES oeuvre_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie ADD CONSTRAINT FK_ADC9FC4D5211C89E FOREIGN KEY (oeuvre_categorie_source) REFERENCES oeuvre_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre ADD categorie_id INT DEFAULT NULL, ADD sous_categorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFEBCF5E72D FOREIGN KEY (categorie_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('CREATE INDEX IDX_35FE2EFEBCF5E72D ON oeuvre (categorie_id)');
    }
}
