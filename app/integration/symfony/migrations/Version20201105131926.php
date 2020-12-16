<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105131926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, street_number INT NOT NULL, street_name VARCHAR(125) NOT NULL, city VARCHAR(125) NOT NULL, country VARCHAR(125) NOT NULL, postal_code VARCHAR(5) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_D4E6F81CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, operator_id INT DEFAULT NULL, machine_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_70C0C6E6F5B7AF75 (address_id), INDEX IDX_70C0C6E6584598A3 (operator_id), INDEX IDX_70C0C6E6F6B75B26 (machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, label LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, family_id INT DEFAULT NULL, code VARCHAR(32) NOT NULL, UNIQUE INDEX UNIQ_64C19C177153098 (code), INDEX IDX_64C19C1C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, agency_id INT DEFAULT NULL, INDEX IDX_1505DF8412469DE2 (category_id), UNIQUE INDEX UNIQ_1505DF84CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine_attribute (id INT AUTO_INCREMENT NOT NULL, attribute_id INT DEFAULT NULL, machine_id INT DEFAULT NULL, value TINYTEXT DEFAULT NULL, INDEX IDX_EEB0D478B6E62EFA (attribute_id), INDEX IDX_EEB0D478F6B75B26 (machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operator (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D7A6A781E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operator_agency (id INT AUTO_INCREMENT NOT NULL, agency_id INT DEFAULT NULL, operator_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_E76F0A63CDEADB2A (agency_id), INDEX IDX_E76F0A63584598A3 (operator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, command VARCHAR(255) NOT NULL, executed_at DATETIME NOT NULL, log_file VARCHAR(255) DEFAULT NULL, terminated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, consumed_at DATETIME DEFAULT NULL, generated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_5F37A13BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE agency ADD CONSTRAINT FK_70C0C6E6F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE agency ADD CONSTRAINT FK_70C0C6E6584598A3 FOREIGN KEY (operator_id) REFERENCES operator (id)');
        $this->addSql('ALTER TABLE agency ADD CONSTRAINT FK_70C0C6E6F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1C35E566A FOREIGN KEY (family_id) REFERENCES family (id)');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF8412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE machine_attribute ADD CONSTRAINT FK_EEB0D478B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE machine_attribute ADD CONSTRAINT FK_EEB0D478F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE operator_agency ADD CONSTRAINT FK_E76F0A63CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE operator_agency ADD CONSTRAINT FK_E76F0A63584598A3 FOREIGN KEY (operator_id) REFERENCES operator (id)');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agency DROP FOREIGN KEY FK_70C0C6E6F5B7AF75');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81CDEADB2A');
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84CDEADB2A');
        $this->addSql('ALTER TABLE operator_agency DROP FOREIGN KEY FK_E76F0A63CDEADB2A');
        $this->addSql('ALTER TABLE machine_attribute DROP FOREIGN KEY FK_EEB0D478B6E62EFA');
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF8412469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1C35E566A');
        $this->addSql('ALTER TABLE agency DROP FOREIGN KEY FK_70C0C6E6F6B75B26');
        $this->addSql('ALTER TABLE machine_attribute DROP FOREIGN KEY FK_EEB0D478F6B75B26');
        $this->addSql('ALTER TABLE agency DROP FOREIGN KEY FK_70C0C6E6584598A3');
        $this->addSql('ALTER TABLE operator_agency DROP FOREIGN KEY FK_E76F0A63584598A3');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BA76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE family');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE machine_attribute');
        $this->addSql('DROP TABLE operator');
        $this->addSql('DROP TABLE operator_agency');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE user');
    }
}
