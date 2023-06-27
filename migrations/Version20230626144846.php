<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626144846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant_activity (participant_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_A2358CA79D1C3019 (participant_id), INDEX IDX_A2358CA781C06096 (activity_id), PRIMARY KEY(participant_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participant_activity ADD CONSTRAINT FK_A2358CA79D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_activity ADD CONSTRAINT FK_A2358CA781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE activity ADD organizer_id INT DEFAULT NULL, ADD site_id INT DEFAULT NULL, ADD place_id INT DEFAULT NULL, ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A876C4DDA FOREIGN KEY (organizer_id) REFERENCES participant (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095ADA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A6BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A876C4DDA ON activity (organizer_id)');
        $this->addSql('CREATE INDEX IDX_AC74095AF6BD1646 ON activity (site_id)');
        $this->addSql('CREATE INDEX IDX_AC74095ADA6A219 ON activity (place_id)');
        $this->addSql('CREATE INDEX IDX_AC74095A6BF700BD ON activity (status_id)');
        $this->addSql('ALTER TABLE place ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_741D53CD8BAC62AF ON place (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, inscription_date DATETIME NOT NULL, activities_activity_no INT NOT NULL, participants_participant_no INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participant_activity DROP FOREIGN KEY FK_A2358CA79D1C3019');
        $this->addSql('ALTER TABLE participant_activity DROP FOREIGN KEY FK_A2358CA781C06096');
        $this->addSql('DROP TABLE participant_activity');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A876C4DDA');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AF6BD1646');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095ADA6A219');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A6BF700BD');
        $this->addSql('DROP INDEX IDX_AC74095A876C4DDA ON activity');
        $this->addSql('DROP INDEX IDX_AC74095AF6BD1646 ON activity');
        $this->addSql('DROP INDEX IDX_AC74095ADA6A219 ON activity');
        $this->addSql('DROP INDEX IDX_AC74095A6BF700BD ON activity');
        $this->addSql('ALTER TABLE activity DROP organizer_id, DROP site_id, DROP place_id, DROP status_id');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD8BAC62AF');
        $this->addSql('DROP INDEX IDX_741D53CD8BAC62AF ON place');
        $this->addSql('ALTER TABLE place DROP city_id');
    }
}
