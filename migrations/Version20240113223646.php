<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240113223646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie DROP FOREIGN KEY FK_ADC9FC4D4BF49811');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie DROP FOREIGN KEY FK_ADC9FC4D5211C89E');
        $this->addSql('DROP TABLE oeuvre_categorie_oeuvre_categorie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE oeuvre_categorie_oeuvre_categorie (oeuvre_categorie_source INT NOT NULL, oeuvre_categorie_target INT NOT NULL, INDEX IDX_ADC9FC4D5211C89E (oeuvre_categorie_source), INDEX IDX_ADC9FC4D4BF49811 (oeuvre_categorie_target), PRIMARY KEY(oeuvre_categorie_source, oeuvre_categorie_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie ADD CONSTRAINT FK_ADC9FC4D4BF49811 FOREIGN KEY (oeuvre_categorie_target) REFERENCES oeuvre_categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE oeuvre_categorie_oeuvre_categorie ADD CONSTRAINT FK_ADC9FC4D5211C89E FOREIGN KEY (oeuvre_categorie_source) REFERENCES oeuvre_categorie (id) ON DELETE CASCADE');
    }
}
