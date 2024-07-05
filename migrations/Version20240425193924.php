<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425193924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre ADD artwork_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE5C5AF308 FOREIGN KEY (artwork_category_id) REFERENCES artwork_category (id)');
        $this->addSql('CREATE INDEX IDX_35FE2EFE5C5AF308 ON oeuvre (artwork_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE5C5AF308');
        $this->addSql('DROP INDEX IDX_35FE2EFE5C5AF308 ON oeuvre');
        $this->addSql('ALTER TABLE oeuvre DROP artwork_category_id');
    }
}
