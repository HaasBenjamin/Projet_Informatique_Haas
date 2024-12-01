<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109084552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assoc_event_date (id INT AUTO_INCREMENT NOT NULL, event_id_id INT NOT NULL, event_dates_id_id INT NOT NULL, INDEX IDX_316BFADE3E5F2F7B (event_id_id), INDEX IDX_316BFADEB25CCD40 (event_dates_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assoc_event_date ADD CONSTRAINT FK_316BFADE3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE assoc_event_date ADD CONSTRAINT FK_316BFADEB25CCD40 FOREIGN KEY (event_dates_id_id) REFERENCES event_date (id)');
        $this->addSql('ALTER TABLE event_date_event DROP FOREIGN KEY FK_D9B03B043DC09FC4');
        $this->addSql('ALTER TABLE event_date_event DROP FOREIGN KEY FK_D9B03B0471F7E88B');
        $this->addSql('DROP TABLE event_date_event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_date_event (event_date_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D9B03B0471F7E88B (event_id), INDEX IDX_D9B03B043DC09FC4 (event_date_id), PRIMARY KEY(event_date_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event_date_event ADD CONSTRAINT FK_D9B03B043DC09FC4 FOREIGN KEY (event_date_id) REFERENCES event_date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_date_event ADD CONSTRAINT FK_D9B03B0471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assoc_event_date DROP FOREIGN KEY FK_316BFADE3E5F2F7B');
        $this->addSql('ALTER TABLE assoc_event_date DROP FOREIGN KEY FK_316BFADEB25CCD40');
        $this->addSql('DROP TABLE assoc_event_date');
    }
}
