<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105163905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency DROP FOREIGN KEY FK_70C0C6E6F6B75B26');
        $this->addSql('DROP INDEX IDX_70C0C6E6F6B75B26 ON agency');
        $this->addSql('ALTER TABLE agency DROP machine_id');
        $this->addSql('ALTER TABLE machine DROP INDEX UNIQ_1505DF84CDEADB2A, ADD INDEX IDX_1505DF84CDEADB2A (agency_id)');
        $this->addSql('ALTER TABLE machine ADD code VARCHAR(32) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1505DF8477153098 ON machine (code)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency ADD machine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agency ADD CONSTRAINT FK_70C0C6E6F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('CREATE INDEX IDX_70C0C6E6F6B75B26 ON agency (machine_id)');
        $this->addSql('ALTER TABLE machine DROP INDEX IDX_1505DF84CDEADB2A, ADD UNIQUE INDEX UNIQ_1505DF84CDEADB2A (agency_id)');
        $this->addSql('DROP INDEX UNIQ_1505DF8477153098 ON machine');
        $this->addSql('ALTER TABLE machine DROP code');
    }
}
