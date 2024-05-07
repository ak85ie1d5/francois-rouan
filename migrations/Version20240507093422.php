<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507093422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_stockage ADD created_by_id INT NOT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP date_debut, DROP date_fin, DROP date_creation, DROP date_modification, DROP titre, DROP createur, DROP modificateur, CHANGE precisions precisions INT DEFAULT NULL, CHANGE type type INT DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_stockage ADD CONSTRAINT FK_36424E04B03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_stockage ADD CONSTRAINT FK_36424E04896DBBDE FOREIGN KEY (updated_by_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_36424E04B03A8386 ON oeuvre_stockage (created_by_id)');
        $this->addSql('CREATE INDEX IDX_36424E04896DBBDE ON oeuvre_stockage (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_stockage DROP FOREIGN KEY FK_36424E04B03A8386');
        $this->addSql('ALTER TABLE oeuvre_stockage DROP FOREIGN KEY FK_36424E04896DBBDE');
        $this->addSql('DROP INDEX IDX_36424E04B03A8386 ON oeuvre_stockage');
        $this->addSql('DROP INDEX IDX_36424E04896DBBDE ON oeuvre_stockage');
        $this->addSql('ALTER TABLE oeuvre_stockage ADD date_creation DATETIME NOT NULL, ADD date_modification DATETIME DEFAULT NULL, ADD titre VARCHAR(255) DEFAULT NULL, ADD createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP created_by_id, DROP updated_by_id, CHANGE precisions precisions VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE created_at date_debut DATETIME NOT NULL, CHANGE updated_at date_fin DATETIME DEFAULT NULL');
    }
}
