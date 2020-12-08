<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208012604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');


        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F8119EB6921');
        $this->addSql('DROP INDEX IDX_D4E6F8119EB6921 ON address');
        $this->addSql('ALTER TABLE address DROP client_id');
        $this->addSql('ALTER TABLE client ADD address VARCHAR(125) NOT NULL, ADD city VARCHAR(125) NOT NULL, ADD country VARCHAR(125) NOT NULL, ADD postal_code VARCHAR(16) NOT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD longitude DOUBLE PRECISION DEFAULT NULL, CHANGE mobile_phone mobile_phone VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F8119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F8119EB6921 ON address (client_id)');
        $this->addSql('ALTER TABLE client DROP address, DROP city, DROP country, DROP postal_code, DROP latitude, DROP longitude, CHANGE mobile_phone mobile_phone VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
