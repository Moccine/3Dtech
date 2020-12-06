<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206153156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(125) NOT NULL, city VARCHAR(125) NOT NULL, country VARCHAR(125) NOT NULL, postal_code VARCHAR(16) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carouselle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, link LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description TINYTEXT DEFAULT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C177153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, first_name VARCHAR(125) NOT NULL, last_name VARCHAR(125) NOT NULL, mobile_phone VARCHAR(50) NOT NULL, home_phone VARCHAR(50) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, address VARCHAR(125) NOT NULL, city VARCHAR(125) NOT NULL, country VARCHAR(125) NOT NULL, postal_code VARCHAR(16) NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64BF3F0277153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deadlines (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, answer LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, description TINYTEXT NOT NULL, discr VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_3D03A11AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE letter (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, subject VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8E02EE0A77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operator (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D7A6A781E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, amount INT DEFAULT NULL, type VARCHAR(50) NOT NULL, INDEX IDX_5A8600B08D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, coupon_id INT DEFAULT NULL, reference VARCHAR(8) NOT NULL, status VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F5299398AEA34913 (reference), INDEX IDX_F529939819EB6921 (client_id), INDEX IDX_F529939866C5951B (coupon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parameter (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2A97911077153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D34A04AD77153098 (code), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `purchase` (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, order_id INT DEFAULT NULL, amount INT NOT NULL, delivery VARCHAR(255) DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_6117D13B4584665A (product_id), INDEX IDX_6117D13B8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, deadline_id INT DEFAULT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TINYTEXT DEFAULT NULL, quotation_date DATE NOT NULL, reference VARCHAR(255) DEFAULT NULL, payment VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, total_ht DOUBLE PRECISION DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, deposit DOUBLE PRECISION DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_474A8DB973EA0AF8 (deadline_id), INDEX IDX_474A8DB919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation_product (quotation_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C36A0E3DB4EA4E60 (quotation_id), INDEX IDX_C36A0E3D4584665A (product_id), PRIMARY KEY(quotation_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_services (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, thumb VARCHAR(255) DEFAULT NULL, links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, consumed_at DATETIME DEFAULT NULL, generated_at DATETIME NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_5F37A13BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voucher (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, order_id INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_1392A5D84584665A (product_id), INDEX IDX_1392A5D88D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B08D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939866C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE `purchase` ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE `purchase` ADD CONSTRAINT FK_6117D13B8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB973EA0AF8 FOREIGN KEY (deadline_id) REFERENCES deadlines (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE quotation_product ADD CONSTRAINT FK_C36A0E3DB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quotation_product ADD CONSTRAINT FK_C36A0E3D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE voucher ADD CONSTRAINT FK_1392A5D84584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE voucher ADD CONSTRAINT FK_1392A5D88D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB919EB6921');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64919EB6921');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939866C5951B');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB973EA0AF8');
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B08D9F6D38');
        $this->addSql('ALTER TABLE `purchase` DROP FOREIGN KEY FK_6117D13B8D9F6D38');
        $this->addSql('ALTER TABLE voucher DROP FOREIGN KEY FK_1392A5D88D9F6D38');
        $this->addSql('ALTER TABLE `purchase` DROP FOREIGN KEY FK_6117D13B4584665A');
        $this->addSql('ALTER TABLE quotation_product DROP FOREIGN KEY FK_C36A0E3D4584665A');
        $this->addSql('ALTER TABLE voucher DROP FOREIGN KEY FK_1392A5D84584665A');
        $this->addSql('ALTER TABLE quotation_product DROP FOREIGN KEY FK_C36A0E3DB4EA4E60');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AA76ED395');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BA76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE carouselle');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE deadlines');
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE letter');
        $this->addSql('DROP TABLE operator');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE parameter');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE `purchase`');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE quotation_product');
        $this->addSql('DROP TABLE section_services');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE voucher');
    }
}
