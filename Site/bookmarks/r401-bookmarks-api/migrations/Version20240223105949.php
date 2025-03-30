<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223105949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bookmark ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE bookmark ADD CONSTRAINT FK_DA62921D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DA62921D7E3C61F9 ON bookmark (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bookmark DROP FOREIGN KEY FK_DA62921D7E3C61F9');
        $this->addSql('DROP INDEX IDX_DA62921D7E3C61F9 ON bookmark');
        $this->addSql('ALTER TABLE bookmark DROP owner_id');
    }
}
