<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251002133902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_sit (id INT AUTO_INCREMENT NOT NULL, showtime_id INT NOT NULL, seat_number VARCHAR(10) NOT NULL, status VARCHAR(20) NOT NULL, user_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6CC4530728BE1523 (showtime_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE showtime (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, hall_number VARCHAR(50) NOT NULL, date_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total_seats INT NOT NULL, available_seats INT NOT NULL, ticket_price DOUBLE PRECISION NOT NULL, INDEX IDX_3248D918F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_sit ADD CONSTRAINT FK_6CC4530728BE1523 FOREIGN KEY (showtime_id) REFERENCES showtime (id)');
        $this->addSql('ALTER TABLE showtime ADD CONSTRAINT FK_3248D918F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_sit DROP FOREIGN KEY FK_6CC4530728BE1523');
        $this->addSql('ALTER TABLE showtime DROP FOREIGN KEY FK_3248D918F93B6FC');
        $this->addSql('DROP TABLE booking_sit');
        $this->addSql('DROP TABLE showtime');
    }
}
