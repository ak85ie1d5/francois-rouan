<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217172320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_utilisateur');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE8A3C7387');
        $this->addSql('DROP INDEX IDX_35FE2EFE8A3C7387 ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre CHANGE categorie_id_id categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFEBCF5E72D FOREIGN KEY (categorie_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('CREATE INDEX IDX_35FE2EFEBCF5E72D ON oeuvre (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_utilisateur (groupe_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_92C1107D7A45358C (groupe_id), INDEX IDX_92C1107DFB88E14F (utilisateur_id), PRIMARY KEY(groupe_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFEBCF5E72D');
        $this->addSql('DROP INDEX IDX_35FE2EFEBCF5E72D ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre CHANGE categorie_id categorie_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE8A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('CREATE INDEX IDX_35FE2EFE8A3C7387 ON oeuvre (categorie_id_id)');
    }
}
