<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323213133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internal_location ADD root_id INT DEFAULT NULL, ADD parent_id INT DEFAULT NULL, ADD lft INT NOT NULL, ADD lvl INT NOT NULL, ADD rgt INT NOT NULL');
        $this->addSql('ALTER TABLE internal_location ADD CONSTRAINT FK_913C041379066886 FOREIGN KEY (root_id) REFERENCES internal_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE internal_location ADD CONSTRAINT FK_913C0413727ACA70 FOREIGN KEY (parent_id) REFERENCES internal_location (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_913C041379066886 ON internal_location (root_id)');
        $this->addSql('CREATE INDEX IDX_913C0413727ACA70 ON internal_location (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internal_location DROP FOREIGN KEY FK_913C041379066886');
        $this->addSql('ALTER TABLE internal_location DROP FOREIGN KEY FK_913C0413727ACA70');
        $this->addSql('DROP INDEX IDX_913C041379066886 ON internal_location');
        $this->addSql('DROP INDEX IDX_913C0413727ACA70 ON internal_location');
        $this->addSql('ALTER TABLE internal_location DROP root_id, DROP parent_id, DROP lft, DROP lvl, DROP rgt');
    }
}
