<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201230234001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB973EA0AF8');
        $this->addSql('DROP INDEX UNIQ_474A8DB973EA0AF8 ON quotation');
        $this->addSql('ALTER TABLE quotation DROP deadline_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quotation ADD deadline_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB973EA0AF8 FOREIGN KEY (deadline_id) REFERENCES deadlines (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_474A8DB973EA0AF8 ON quotation (deadline_id)');
    }
}
