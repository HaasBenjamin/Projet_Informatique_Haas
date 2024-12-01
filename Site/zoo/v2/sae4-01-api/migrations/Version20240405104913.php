<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405104913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, parent1_id INT DEFAULT NULL, parent2_id INT DEFAULT NULL, species_id INT NOT NULL, enclosure_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_6AAB231F861B2665 (parent1_id), INDEX IDX_6AAB231F94AE898B (parent2_id), INDEX IDX_6AAB231FB2A1D860 (species_id), INDEX IDX_6AAB231FD04FE1E5 (enclosure_id), INDEX IDX_6AAB231F3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_category (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_C0CF1F1C3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_diet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_family (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_1F17E48712469DE2 (category_id), INDEX IDX_1F17E4873DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclosure (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT NOT NULL, name VARCHAR(256) NOT NULL, description VARCHAR(512) NOT NULL, duration INT NOT NULL, quota INT NOT NULL, INDEX IDX_3BAE0AA7D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_event_date (event_id INT NOT NULL, event_date_id INT NOT NULL, INDEX IDX_EDBBA2FE71F7E88B (event_id), INDEX IDX_EDBBA2FE3DC09FC4 (event_date_id), PRIMARY KEY(event_id, event_date_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_date (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, nb_reserved_places INT NOT NULL, INDEX IDX_62A8A7A771F7E88B (event_id), INDEX IDX_62A8A7A7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, diet_id INT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, description VARCHAR(512) NOT NULL, INDEX IDX_A50FF712C35E566A (family_id), INDEX IDX_A50FF712E1E13ACE (diet_id), INDEX IDX_A50FF7123DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(128) NOT NULL, firstname VARCHAR(128) NOT NULL, date_of_birth DATETIME NOT NULL, hiring_date DATETIME DEFAULT NULL, contract_duration INT DEFAULT NULL, date_visitor DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F861B2665 FOREIGN KEY (parent1_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F94AE898B FOREIGN KEY (parent2_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE animal_category ADD CONSTRAINT FK_C0CF1F1C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE animal_family ADD CONSTRAINT FK_1F17E48712469DE2 FOREIGN KEY (category_id) REFERENCES animal_category (id)');
        $this->addSql('ALTER TABLE animal_family ADD CONSTRAINT FK_1F17E4873DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosure (id)');
        $this->addSql('ALTER TABLE event_event_date ADD CONSTRAINT FK_EDBBA2FE71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_event_date ADD CONSTRAINT FK_EDBBA2FE3DC09FC4 FOREIGN KEY (event_date_id) REFERENCES event_date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A771F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF712C35E566A FOREIGN KEY (family_id) REFERENCES animal_family (id)');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF712E1E13ACE FOREIGN KEY (diet_id) REFERENCES animal_diet (id)');
        $this->addSql('ALTER TABLE species ADD CONSTRAINT FK_A50FF7123DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F861B2665');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F94AE898B');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD04FE1E5');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F3DA5256D');
        $this->addSql('ALTER TABLE animal_category DROP FOREIGN KEY FK_C0CF1F1C3DA5256D');
        $this->addSql('ALTER TABLE animal_family DROP FOREIGN KEY FK_1F17E48712469DE2');
        $this->addSql('ALTER TABLE animal_family DROP FOREIGN KEY FK_1F17E4873DA5256D');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7D04FE1E5');
        $this->addSql('ALTER TABLE event_event_date DROP FOREIGN KEY FK_EDBBA2FE71F7E88B');
        $this->addSql('ALTER TABLE event_event_date DROP FOREIGN KEY FK_EDBBA2FE3DC09FC4');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A771F7E88B');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A7A76ED395');
        $this->addSql('ALTER TABLE species DROP FOREIGN KEY FK_A50FF712C35E566A');
        $this->addSql('ALTER TABLE species DROP FOREIGN KEY FK_A50FF712E1E13ACE');
        $this->addSql('ALTER TABLE species DROP FOREIGN KEY FK_A50FF7123DA5256D');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_category');
        $this->addSql('DROP TABLE animal_diet');
        $this->addSql('DROP TABLE animal_family');
        $this->addSql('DROP TABLE enclosure');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_event_date');
        $this->addSql('DROP TABLE event_date');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE species');
        $this->addSql('DROP TABLE user');
    }
}
