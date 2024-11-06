<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105235337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD pick_up_store_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398519F2244 FOREIGN KEY (pick_up_store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_F5299398519F2244 ON `order` (pick_up_store_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398519F2244');
        $this->addSql('DROP INDEX IDX_F5299398519F2244 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP pick_up_store_id');
    }
}
