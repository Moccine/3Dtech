<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201215223705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE quotation_product');
        $this->addSql('ALTER TABLE quotation_line ADD quotation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation_line ADD CONSTRAINT FK_4CE011BAB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id)');
        $this->addSql('CREATE INDEX IDX_4CE011BAB4EA4E60 ON quotation_line (quotation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quotation_product (quotation_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_C36A0E3D4584665A (product_id), INDEX IDX_C36A0E3DB4EA4E60 (quotation_id), PRIMARY KEY(quotation_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quotation_product ADD CONSTRAINT FK_C36A0E3D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quotation_product ADD CONSTRAINT FK_C36A0E3DB4EA4E60 FOREIGN KEY (quotation_id) REFERENCES quotation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quotation_line DROP FOREIGN KEY FK_4CE011BAB4EA4E60');
        $this->addSql('DROP INDEX IDX_4CE011BAB4EA4E60 ON quotation_line');
        $this->addSql('ALTER TABLE quotation_line DROP quotation_id');
    }
}
