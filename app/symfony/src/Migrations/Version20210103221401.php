<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103221401 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5D5B7FD2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB5B63A6B');
        $this->addSql('DROP INDEX IDX_D34A04AD5D5B7FD2 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADB5B63A6B ON product');
        $this->addSql('ALTER TABLE product DROP vat_id, DROP quotation_line_id');
        $this->addSql('ALTER TABLE quotation_line ADD vat_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quotation_line ADD CONSTRAINT FK_4CE011BAB5B63A6B FOREIGN KEY (vat_id) REFERENCES vat (id)');
        $this->addSql('ALTER TABLE quotation_line ADD CONSTRAINT FK_4CE011BA4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_4CE011BAB5B63A6B ON quotation_line (vat_id)');
        $this->addSql('CREATE INDEX IDX_4CE011BA4584665A ON quotation_line (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product ADD vat_id INT DEFAULT NULL, ADD quotation_line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5D5B7FD2 FOREIGN KEY (quotation_line_id) REFERENCES quotation_line (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB5B63A6B FOREIGN KEY (vat_id) REFERENCES vat (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD5D5B7FD2 ON product (quotation_line_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADB5B63A6B ON product (vat_id)');
        $this->addSql('ALTER TABLE quotation_line DROP FOREIGN KEY FK_4CE011BAB5B63A6B');
        $this->addSql('ALTER TABLE quotation_line DROP FOREIGN KEY FK_4CE011BA4584665A');
        $this->addSql('DROP INDEX IDX_4CE011BAB5B63A6B ON quotation_line');
        $this->addSql('DROP INDEX IDX_4CE011BA4584665A ON quotation_line');
        $this->addSql('ALTER TABLE quotation_line DROP vat_id, DROP product_id');
    }
}
