<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627075444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP username, DROP mail, DROP password');
        $this->addSql('ALTER TABLE participant_activity DROP inscriptionDate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD username VARCHAR(50) NOT NULL, ADD mail VARCHAR(25) NOT NULL, ADD password VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE participant_activity ADD inscriptionDate DATETIME DEFAULT NULL');
    }
}
