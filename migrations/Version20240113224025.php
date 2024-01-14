<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240113224025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_categorie ADD oeuvre_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_categorie ADD CONSTRAINT FK_50ED1EBFA2B9DD57 FOREIGN KEY (oeuvre_categorie_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('CREATE INDEX IDX_50ED1EBFA2B9DD57 ON oeuvre_categorie (oeuvre_categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_categorie DROP FOREIGN KEY FK_50ED1EBFA2B9DD57');
        $this->addSql('DROP INDEX IDX_50ED1EBFA2B9DD57 ON oeuvre_categorie');
        $this->addSql('ALTER TABLE oeuvre_categorie DROP oeuvre_categorie_id');
    }
}
