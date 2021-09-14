<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907080208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add illustration entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE illustration (id INT AUTO_INCREMENT NOT NULL, images_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D67B9A42D44F05E5 (images_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE illustration ADD CONSTRAINT FK_D67B9A42D44F05E5 FOREIGN KEY (images_id) REFERENCES figure (id)');
        $this->addSql('ALTER TABLE figure ADD videos LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE illustration');
        $this->addSql('ALTER TABLE figure DROP videos');
    }
}
