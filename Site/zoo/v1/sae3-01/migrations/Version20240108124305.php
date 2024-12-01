<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108124305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB1C0859');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F2D191E7A');
        $this->addSql('CREATE TABLE animal_category (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_C0CF1F1C3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_diet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_family (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_1F17E48712469DE2 (category_id), INDEX IDX_1F17E4873DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclosure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT NOT NULL, name VARCHAR(256) NOT NULL, description VARCHAR(512) NOT NULL, duration INT NOT NULL, quota INT NOT NULL, INDEX IDX_3BAE0AA7D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_date (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_date_event (event_date_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D9B03B043DC09FC4 (event_date_id), INDEX IDX_D9B03B0471F7E88B (event_id), PRIMARY KEY(event_date_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, nb_reserved_places INT NOT NULL, INDEX IDX_62A8A7A771F7E88B (event_id), INDEX IDX_62A8A7A7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, diet_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_A50FF712C35E566A (family_id), INDEX IDX_A50FF712E1E13ACE (diet_id), INDEX IDX_A50FF7123DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, last_name VARCHAR(128) NOT NULL, first_name VARCHAR(128) NOT NULL, date_of_birth DATETIME NOT NULL, hiring_date DATETIME DEFAULT NULL, contract_duration INT DEFAULT NULL, date_visitor DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_category ADD CONSTRAINT FK_C0CF1F1C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE animal_family ADD CONSTRAINT FK_1F17E48712469DE2 FOREIGN KEY (category_id) REFERENCES animal_category (id)');
        $this->addSql('ALTER TABLE animal_family ADD CONSTRAINT FK_1F17E4873DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('ALTER TABLE event_date_event ADD CONSTRAINT FK_D9B03B043DC09FC4 FOREIGN KEY (event_date_id) REFERENCES event_date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_date_event ADD CONSTRAINT FK_D9B03B0471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A771F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF712C35E566A FOREIGN KEY (family_id) REFERENCES animal_family (id)');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF712E1E13ACE FOREIGN KEY (diet_id) REFERENCES animal_diet (id)');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF7123DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE espece DROP FOREIGN KEY FK_1A2A1B135E7D534');
        $this->addSql('ALTER TABLE espece DROP FOREIGN KEY FK_1A2A1B13DA5256D');
        $this->addSql('ALTER TABLE espece DROP FOREIGN KEY FK_1A2A1B197A77B84');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB1C0859');
        $this->addSql('ALTER TABLE famille_animal DROP FOREIGN KEY FK_CD658AB3DA5256D');
        $this->addSql('ALTER TABLE famille_animal DROP FOREIGN KEY FK_CD658ABBCF5E72D');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FB88E14F');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FD02F13');
        $this->addSql('ALTER TABLE categorie_animal DROP FOREIGN KEY FK_EC8D89263DA5256D');
        $this->addSql('DROP TABLE enclos');
        $this->addSql('DROP TABLE regime');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE espece');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE famille_animal');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE categorie_animal');
        $this->addSql('DROP INDEX IDX_6AAB231FB1C0859 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231F2D191E7A ON animal');
        $this->addSql('ALTER TABLE animal ADD species_id INT NOT NULL, ADD enclosure_id INT NOT NULL, DROP espece_id, DROP enclos_id, CHANGE nom_animal name VARCHAR(128) NOT NULL, CHANGE description_animal description VARCHAR(512) NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FD04FE1E5 ON animal (enclosure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD04FE1E5');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, nom_enclos VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE regime (id INT AUTO_INCREMENT NOT NULL, nom_regime VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom_user VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, pnom_user VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_nais_user DATETIME NOT NULL, date_embauche DATETIME DEFAULT NULL, duree_contrat INT DEFAULT NULL, date_visiteur DATETIME DEFAULT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE espece (id INT AUTO_INCREMENT NOT NULL, famille_id INT NOT NULL, regime_id INT NOT NULL, image_id INT DEFAULT NULL, lib_espece VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_espece VARCHAR(512) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1A2A1B135E7D534 (regime_id), INDEX IDX_1A2A1B197A77B84 (famille_id), INDEX IDX_1A2A1B13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, enclos_id INT NOT NULL, nom_evenement VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_evenement VARCHAR(512) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_evenement DATETIME NOT NULL, duree_evenement INT NOT NULL, quota_visiteurs INT NOT NULL, INDEX IDX_B26681EB1C0859 (enclos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE famille_animal (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, image_id INT DEFAULT NULL, nom_famille VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_famille VARCHAR(512) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CD658AB3DA5256D (image_id), INDEX IDX_CD658ABBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, utilisateur_id INT NOT NULL, date_inscription DATETIME NOT NULL, nb_place_reservees INT NOT NULL, INDEX IDX_5E90F6D6FD02F13 (evenement_id), INDEX IDX_5E90F6D6FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie_animal (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, nom_categorie VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_categorie VARCHAR(512) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_EC8D89263DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE espece ADD CONSTRAINT FK_1A2A1B135E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id)');
        $this->addSql('ALTER TABLE espece ADD CONSTRAINT FK_1A2A1B13DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE espece ADD CONSTRAINT FK_1A2A1B197A77B84 FOREIGN KEY (famille_id) REFERENCES famille_animal (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id)');
        $this->addSql('ALTER TABLE famille_animal ADD CONSTRAINT FK_CD658AB3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE famille_animal ADD CONSTRAINT FK_CD658ABBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_animal (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE categorie_animal ADD CONSTRAINT FK_EC8D89263DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE animal_category DROP FOREIGN KEY FK_C0CF1F1C3DA5256D');
        $this->addSql('ALTER TABLE animal_family DROP FOREIGN KEY FK_1F17E48712469DE2');
        $this->addSql('ALTER TABLE animal_family DROP FOREIGN KEY FK_1F17E4873DA5256D');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7D04FE1E5');
        $this->addSql('ALTER TABLE event_date_event DROP FOREIGN KEY FK_D9B03B043DC09FC4');
        $this->addSql('ALTER TABLE event_date_event DROP FOREIGN KEY FK_D9B03B0471F7E88B');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A771F7E88B');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7A76ED395');
        $this->addSql('ALTER TABLE species DROP FOREIGN KEY FK_A50FF712C35E566A');
        $this->addSql('ALTER TABLE species DROP FOREIGN KEY FK_A50FF712E1E13ACE');
        $this->addSql('ALTER TABLE species DROP FOREIGN KEY FK_A50FF7123DA5256D');
        $this->addSql('DROP TABLE animal_category');
        $this->addSql('DROP TABLE animal_diet');
        $this->addSql('DROP TABLE animal_family');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_date');
        $this->addSql('DROP TABLE event_date_event');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231FD04FE1E5 ON animal');
        $this->addSql('ALTER TABLE animal ADD espece_id INT NOT NULL, ADD enclos_id INT NOT NULL, DROP species_id, DROP enclosure_id, CHANGE name nom_animal VARCHAR(128) NOT NULL, CHANGE description description_animal VARCHAR(512) NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB1C0859 ON animal (enclos_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F2D191E7A ON animal (espece_id)');
    }
}
