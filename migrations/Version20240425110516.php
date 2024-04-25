<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425110516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artwork_category (id INT AUTO_INCREMENT NOT NULL, root_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lft INT NOT NULL, lvl INT NOT NULL, rgt INT NOT NULL, INDEX IDX_FA06D53F79066886 (root_id), INDEX IDX_FA06D53F727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F79066886 FOREIGN KEY (root_id) REFERENCES artwork_category (id)');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F727ACA70 FOREIGN KEY (parent_id) REFERENCES artwork_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F79066886');
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F727ACA70');
        $this->addSql('DROP TABLE artwork_category');
    }
}
