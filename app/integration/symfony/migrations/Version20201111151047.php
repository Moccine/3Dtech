<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111151047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, user_id INT DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, first_name VARCHAR(125) NOT NULL, last_name VARCHAR(125) NOT NULL, phone VARCHAR(50) NOT NULL, siret VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_C7440455F5B7AF75 (address_id), UNIQUE INDEX UNIQ_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64BF3F0277153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, amount INT NOT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_5A8600B08D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `purchase` (id INT AUTO_INCREMENT NOT NULL, machine_id INT DEFAULT NULL, order_id INT DEFAULT NULL, amount INT NOT NULL, delivery VARCHAR(255) NOT NULL, INDEX IDX_6117D13BF6B75B26 (machine_id), INDEX IDX_6117D13B8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE submission (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, message LONGTEXT NOT NULL, submitted_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_DB055AF3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B08D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `purchase` ADD CONSTRAINT FK_6117D13BF6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
        $this->addSql('ALTER TABLE `purchase` ADD CONSTRAINT FK_6117D13B8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD client_id INT NOT NULL, ADD coupon_id INT DEFAULT NULL, ADD reference VARCHAR(8) NOT NULL, ADD status VARCHAR(50) NOT NULL, ADD type VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939866C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398AEA34913 ON `order` (reference)');
        $this->addSql('CREATE INDEX IDX_F529939819EB6921 ON `order` (client_id)');
        $this->addSql('CREATE INDEX IDX_F529939866C5951B ON `order` (coupon_id)');
        $this->addSql('ALTER TABLE user ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64919EB6921 ON user (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939866C5951B');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE `purchase`');
        $this->addSql('DROP TABLE submission');
        $this->addSql('DROP INDEX UNIQ_F5299398AEA34913 ON `order`');
        $this->addSql('DROP INDEX IDX_F529939819EB6921 ON `order`');
        $this->addSql('DROP INDEX IDX_F529939866C5951B ON `order`');
        $this->addSql('ALTER TABLE `order` DROP client_id, DROP coupon_id, DROP reference, DROP status, DROP type');
        $this->addSql('DROP INDEX UNIQ_8D93D64919EB6921 ON user');
        $this->addSql('ALTER TABLE user DROP client_id');
    }
}
