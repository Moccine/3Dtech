<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218230847 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE slide_show ADD code VARCHAR(255) NOT NULL, CHANGE name title VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5CE37D577153098 ON slide_show (code)');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710071D87D6D');
        $this->addSql('DROP INDEX IDX_CFC710071D87D6D ON slider');
        $this->addSql('ALTER TABLE slider ADD updated_at DATETIME DEFAULT NULL, DROP description, DROP quotation_form_link, DROP discovery_link, CHANGE slide_show_id slideshow_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710078B14E343 FOREIGN KEY (slideshow_id) REFERENCES slide_show (id)');
        $this->addSql('CREATE INDEX IDX_CFC710078B14E343 ON slider (slideshow_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_5CE37D577153098 ON slide_show');
        $this->addSql('ALTER TABLE slide_show ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP title, DROP code');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710078B14E343');
        $this->addSql('DROP INDEX IDX_CFC710078B14E343 ON slider');
        $this->addSql('ALTER TABLE slider ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD quotation_form_link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD discovery_link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP updated_at, CHANGE slideshow_id slide_show_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710071D87D6D FOREIGN KEY (slide_show_id) REFERENCES slide_show (id)');
        $this->addSql('CREATE INDEX IDX_CFC710071D87D6D ON slider (slide_show_id)');
    }
}
