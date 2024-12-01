<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127103521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, espece_id INT NOT NULL, enclos_id INT NOT NULL, image_id INT DEFAULT NULL, parent1_id INT DEFAULT NULL, parent2_id INT DEFAULT NULL, nom_animal VARCHAR(128) NOT NULL, description_animal VARCHAR(512) NOT NULL, INDEX IDX_6AAB231F2D191E7A (espece_id), INDEX IDX_6AAB231FB1C0859 (enclos_id), INDEX IDX_6AAB231F3DA5256D (image_id), INDEX IDX_6AAB231F861B2665 (parent1_id), INDEX IDX_6AAB231F94AE898B (parent2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_animal (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(128) NOT NULL, description_categorie VARCHAR(512) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclos (id INT AUTO_INCREMENT NOT NULL, nom_enclos VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espece (id INT AUTO_INCREMENT NOT NULL, famille_id INT NOT NULL, regime_id INT NOT NULL, image_id INT DEFAULT NULL, lib_espece VARCHAR(128) NOT NULL, description_espece VARCHAR(512) NOT NULL, INDEX IDX_1A2A1B197A77B84 (famille_id), INDEX IDX_1A2A1B135E7D534 (regime_id), INDEX IDX_1A2A1B13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, enclos_id INT NOT NULL, nom_evenement VARCHAR(256) NOT NULL, description_evenement VARCHAR(512) NOT NULL, date_evenement DATETIME NOT NULL, duree_evenement INT NOT NULL, quota_visiteurs INT NOT NULL, INDEX IDX_B26681EB1C0859 (enclos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE famille_animal (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, image_id INT DEFAULT NULL, nom_famille VARCHAR(128) NOT NULL, description_famille VARCHAR(512) NOT NULL, INDEX IDX_CD658ABBCF5E72D (categorie_id), INDEX IDX_CD658AB3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, evenement_id INT NOT NULL, utilisateur_id INT NOT NULL, date_inscription DATETIME NOT NULL, nb_place_reservees INT NOT NULL, INDEX IDX_5E90F6D6FD02F13 (evenement_id), INDEX IDX_5E90F6D6FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime (id INT AUTO_INCREMENT NOT NULL, nom_regime VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, login_user LONGTEXT NOT NULL, mdp_user LONGTEXT NOT NULL, nom_user VARCHAR(128) NOT NULL, pnom_user VARCHAR(128) NOT NULL, date_nais_user DATETIME NOT NULL, email_user VARCHAR(256) NOT NULL, date_embauche DATETIME DEFAULT NULL, duree_contrat INT DEFAULT NULL, date_visiteur DATETIME DEFAULT NULL, role VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F2D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F861B2665 FOREIGN KEY (parent1_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F94AE898B FOREIGN KEY (parent2_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE espece ADD CONSTRAINT FK_1A2A1B197A77B84 FOREIGN KEY (famille_id) REFERENCES famille_animal (id)');
        $this->addSql('ALTER TABLE espece ADD CONSTRAINT FK_1A2A1B135E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id)');
        $this->addSql('ALTER TABLE espece ADD CONSTRAINT FK_1A2A1B13DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB1C0859 FOREIGN KEY (enclos_id) REFERENCES enclos (id)');
        $this->addSql('ALTER TABLE famille_animal ADD CONSTRAINT FK_CD658ABBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_animal (id)');
        $this->addSql('ALTER TABLE famille_animal ADD CONSTRAINT FK_CD658AB3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F2D191E7A');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB1C0859');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F3DA5256D');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F861B2665');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F94AE898B');
        $this->addSql('ALTER TABLE espece DROP FOREIGN KEY FK_1A2A1B197A77B84');
        $this->addSql('ALTER TABLE espece DROP FOREIGN KEY FK_1A2A1B135E7D534');
        $this->addSql('ALTER TABLE espece DROP FOREIGN KEY FK_1A2A1B13DA5256D');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB1C0859');
        $this->addSql('ALTER TABLE famille_animal DROP FOREIGN KEY FK_CD658ABBCF5E72D');
        $this->addSql('ALTER TABLE famille_animal DROP FOREIGN KEY FK_CD658AB3DA5256D');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FD02F13');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FB88E14F');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE categorie_animal');
        $this->addSql('DROP TABLE enclos');
        $this->addSql('DROP TABLE espece');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE famille_animal');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE regime');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
