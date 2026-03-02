<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251218204909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F79066886');
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F727ACA70');
        $this->addSql('ALTER TABLE artwork_category DROP name');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F79066886 FOREIGN KEY (root_id) REFERENCES artwork_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F727ACA70 FOREIGN KEY (parent_id) REFERENCES artwork_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F79066886');
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F727ACA70');
        $this->addSql('ALTER TABLE artwork_category ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F79066886 FOREIGN KEY (root_id) REFERENCES artwork_category (id)');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F727ACA70 FOREIGN KEY (parent_id) REFERENCES artwork_category (id)');
    }
}
