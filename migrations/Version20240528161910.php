<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528161910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBF73A201E5');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP FOREIGN KEY FK_614B6BBFD3DF658');
        $this->addSql('DROP INDEX IDX_614B6BBF73A201E5 ON oeuvre_media_test');
        $this->addSql('DROP INDEX IDX_614B6BBFD3DF658 ON oeuvre_media_test');
        $this->addSql('ALTER TABLE oeuvre_media_test DROP createur_id, DROP modificateur_id, DROP date_creation, DROP date_modification, DROP emplacement, DROP extension');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE oeuvre_media_test ADD createur_id INT NOT NULL, ADD modificateur_id INT DEFAULT NULL, ADD date_creation DATETIME NOT NULL, ADD date_modification DATETIME DEFAULT NULL, ADD emplacement VARCHAR(30) DEFAULT NULL, ADD extension VARCHAR(5) DEFAULT NULL');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBF73A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE oeuvre_media_test ADD CONSTRAINT FK_614B6BBFD3DF658 FOREIGN KEY (modificateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_614B6BBF73A201E5 ON oeuvre_media_test (createur_id)');
        $this->addSql('CREATE INDEX IDX_614B6BBFD3DF658 ON oeuvre_media_test (modificateur_id)');
    }
}
