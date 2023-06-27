<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627095209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE participant DROP username, DROP mail, DROP password');
        $this->addSql('ALTER TABLE status CHANGE status_label status_label VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, inscription_date DATETIME NOT NULL, activities_activity_no INT NOT NULL, participants_participant_no INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE status CHANGE status_label status_label INT NOT NULL');
        $this->addSql('ALTER TABLE participant ADD username VARCHAR(50) NOT NULL, ADD mail VARCHAR(25) NOT NULL, ADD password VARCHAR(30) NOT NULL');
    }
}
