<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231109142514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, part_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, vendor_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor_part (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, part_id INT NOT NULL, vendor_part_number VARCHAR(255) NOT NULL, INDEX IDX_63C27519F603EE73 (vendor_id), INDEX IDX_63C275194CE34BEC (part_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendor_part ADD CONSTRAINT FK_63C27519F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('ALTER TABLE vendor_part ADD CONSTRAINT FK_63C275194CE34BEC FOREIGN KEY (part_id) REFERENCES part (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendor_part DROP FOREIGN KEY FK_63C27519F603EE73');
        $this->addSql('ALTER TABLE vendor_part DROP FOREIGN KEY FK_63C275194CE34BEC');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP TABLE vendor_part');
    }
}
