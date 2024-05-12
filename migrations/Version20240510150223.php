<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510150223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre ADD first_day INT DEFAULT NULL, ADD first_month INT DEFAULT NULL, ADD first_year INT NOT NULL, ADD first_date_uncertain TINYINT(1) NOT NULL, ADD second_day INT DEFAULT NULL, ADD second_month INT DEFAULT NULL, ADD second_year INT NOT NULL, ADD second_date_uncertain TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP first_day, DROP first_month, DROP first_year, DROP first_date_uncertain, DROP second_day, DROP second_month, DROP second_year, DROP second_date_uncertain');
    }
}
