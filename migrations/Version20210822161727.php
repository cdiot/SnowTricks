<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210822161727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation between figure and category entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_2F57B37A12469DE2 ON figure (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A12469DE2');
        $this->addSql('DROP INDEX IDX_2F57B37A12469DE2 ON figure');
        $this->addSql('ALTER TABLE figure DROP category_id');
    }
}
