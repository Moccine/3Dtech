<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201229214950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE vat (id INT AUTO_INCREMENT NOT NULL, name DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD vat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB5B63A6B FOREIGN KEY (vat_id) REFERENCES vat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADB5B63A6B ON product (vat_id)');
        $this->addSql('ALTER TABLE quotation ADD discount NUMERIC(10, 2) DEFAULT NULL, DROP address, CHANGE amount amount NUMERIC(10, 2) DEFAULT NULL, CHANGE total_ht total_ht NUMERIC(10, 2) DEFAULT NULL, CHANGE quantity quantity NUMERIC(10, 2) DEFAULT NULL, CHANGE deposit deposit NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation_line DROP deposit');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB5B63A6B');
        $this->addSql('DROP TABLE vat');
        $this->addSql('DROP INDEX UNIQ_D34A04ADB5B63A6B ON product');
        $this->addSql('ALTER TABLE product DROP vat_id');
        $this->addSql('ALTER TABLE quotation ADD address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP discount, CHANGE amount amount DOUBLE PRECISION DEFAULT NULL, CHANGE total_ht total_ht DOUBLE PRECISION DEFAULT NULL, CHANGE quantity quantity DOUBLE PRECISION DEFAULT NULL, CHANGE deposit deposit DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation_line ADD deposit DOUBLE PRECISION DEFAULT NULL');
    }
}
