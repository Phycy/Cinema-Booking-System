<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014060012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_sit ADD user_id INT NOT NULL, DROP user_name');
        $this->addSql('ALTER TABLE booking_sit ADD CONSTRAINT FK_6CC45307A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6CC45307A76ED395 ON booking_sit (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_sit DROP FOREIGN KEY FK_6CC45307A76ED395');
        $this->addSql('DROP INDEX IDX_6CC45307A76ED395 ON booking_sit');
        $this->addSql('ALTER TABLE booking_sit ADD user_name VARCHAR(255) DEFAULT NULL, DROP user_id');
    }
}
