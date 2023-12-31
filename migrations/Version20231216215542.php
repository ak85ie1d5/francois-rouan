<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231216215542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', date_modification DATETIME DEFAULT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_oeuvre_categorie_perm (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_28699DB7A45358C (groupe_id), INDEX IDX_28699DBBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, tel1 VARCHAR(255) DEFAULT NULL, tel2 VARCHAR(255) DEFAULT NULL, tel3 VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', organisme VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre (id INT AUTO_INCREMENT NOT NULL, categorie_id_id INT DEFAULT NULL, num_inventaire VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) NOT NULL, sous_titre VARCHAR(255) DEFAULT NULL, serie LONGTEXT DEFAULT NULL, date DATE DEFAULT NULL, date_complement VARCHAR(255) DEFAULT NULL, dimensions VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, commentaire_public LONGTEXT DEFAULT NULL, sous_categorie INT DEFAULT NULL, details LONGTEXT DEFAULT NULL, medias LONGTEXT NOT NULL COMMENT \'(DC2Type:json_document)\', nb_medias INT NOT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', commentaire_interne LONGTEXT DEFAULT NULL, INDEX IDX_35FE2EFE8A3C7387 (categorie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre_bibliographie (id INT AUTO_INCREMENT NOT NULL, oeuvre_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_56331A9888194DE8 (oeuvre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre_categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, sous_categories LONGTEXT NOT NULL COMMENT \'(DC2Type:json_document)\', date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre_exposition (id INT AUTO_INCREMENT NOT NULL, lieu_id INT DEFAULT NULL, oeuvre_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_C64237736AB213CC (lieu_id), INDEX IDX_C642377388194DE8 (oeuvre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre_historique (id INT AUTO_INCREMENT NOT NULL, oeuvre_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', INDEX IDX_97CC1F8C88194DE8 (oeuvre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oeuvre_stockage (id INT AUTO_INCREMENT NOT NULL, oeuvre_id INT DEFAULT NULL, lieu_id INT DEFAULT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', precisions VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_36424E0488194DE8 (oeuvre_id), INDEX IDX_36424E046AB213CC (lieu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parametre (id INT AUTO_INCREMENT NOT NULL, espace_utilise BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, identifiant VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL, date_modification DATETIME DEFAULT NULL, derniere_connexion DATETIME DEFAULT NULL, createur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', modificateur LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_groupe (utilisateur_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_6514B6AAFB88E14F (utilisateur_id), INDEX IDX_6514B6AA7A45358C (groupe_id), PRIMARY KEY(utilisateur_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm ADD CONSTRAINT FK_28699DB7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm ADD CONSTRAINT FK_28699DBBCF5E72D FOREIGN KEY (categorie_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('ALTER TABLE oeuvre ADD CONSTRAINT FK_35FE2EFE8A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES oeuvre_categorie (id)');
        $this->addSql('ALTER TABLE oeuvre_bibliographie ADD CONSTRAINT FK_56331A9888194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE oeuvre_exposition ADD CONSTRAINT FK_C64237736AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE oeuvre_exposition ADD CONSTRAINT FK_C642377388194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE oeuvre_historique ADD CONSTRAINT FK_97CC1F8C88194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE oeuvre_stockage ADD CONSTRAINT FK_36424E0488194DE8 FOREIGN KEY (oeuvre_id) REFERENCES oeuvre (id)');
        $this->addSql('ALTER TABLE oeuvre_stockage ADD CONSTRAINT FK_36424E046AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AAFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_groupe ADD CONSTRAINT FK_6514B6AA7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm DROP FOREIGN KEY FK_28699DB7A45358C');
        $this->addSql('ALTER TABLE groupe_oeuvre_categorie_perm DROP FOREIGN KEY FK_28699DBBCF5E72D');
        $this->addSql('ALTER TABLE oeuvre DROP FOREIGN KEY FK_35FE2EFE8A3C7387');
        $this->addSql('ALTER TABLE oeuvre_bibliographie DROP FOREIGN KEY FK_56331A9888194DE8');
        $this->addSql('ALTER TABLE oeuvre_exposition DROP FOREIGN KEY FK_C64237736AB213CC');
        $this->addSql('ALTER TABLE oeuvre_exposition DROP FOREIGN KEY FK_C642377388194DE8');
        $this->addSql('ALTER TABLE oeuvre_historique DROP FOREIGN KEY FK_97CC1F8C88194DE8');
        $this->addSql('ALTER TABLE oeuvre_stockage DROP FOREIGN KEY FK_36424E0488194DE8');
        $this->addSql('ALTER TABLE oeuvre_stockage DROP FOREIGN KEY FK_36424E046AB213CC');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AAFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_groupe DROP FOREIGN KEY FK_6514B6AA7A45358C');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_oeuvre_categorie_perm');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE oeuvre');
        $this->addSql('DROP TABLE oeuvre_bibliographie');
        $this->addSql('DROP TABLE oeuvre_categorie');
        $this->addSql('DROP TABLE oeuvre_exposition');
        $this->addSql('DROP TABLE oeuvre_historique');
        $this->addSql('DROP TABLE oeuvre_stockage');
        $this->addSql('DROP TABLE parametre');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_groupe');
    }
}
