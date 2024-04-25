<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425162358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_category ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, DROP created_by, DROP updated_by');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53FB03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE artwork_category ADD CONSTRAINT FK_FA06D53F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_FA06D53FB03A8386 ON artwork_category (created_by_id)');
        $this->addSql('CREATE INDEX IDX_FA06D53F896DBBDE ON artwork_category (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53FB03A8386');
        $this->addSql('ALTER TABLE artwork_category DROP FOREIGN KEY FK_FA06D53F896DBBDE');
        $this->addSql('DROP INDEX IDX_FA06D53FB03A8386 ON artwork_category');
        $this->addSql('DROP INDEX IDX_FA06D53F896DBBDE ON artwork_category');
        $this->addSql('ALTER TABLE artwork_category ADD created_by VARCHAR(255) DEFAULT NULL, ADD updated_by VARCHAR(255) DEFAULT NULL, DROP created_by_id, DROP updated_by_id');
    }
}
