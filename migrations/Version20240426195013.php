<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426195013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE football_match (id INT AUTO_INCREMENT NOT NULL, home_team_id INT DEFAULT NULL, away_team_id INT DEFAULT NULL, matchday INT NOT NULL, date VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, home_score INT DEFAULT NULL, away_score INT DEFAULT NULL, external_id INT NOT NULL, INDEX IDX_8CE33ACE9C4C13F6 (home_team_id), INDEX IDX_8CE33ACE45185D02 (away_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE football_match ADD CONSTRAINT FK_8CE33ACE45185D02 FOREIGN KEY (away_team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE9C4C13F6');
        $this->addSql('ALTER TABLE football_match DROP FOREIGN KEY FK_8CE33ACE45185D02');
        $this->addSql('DROP TABLE football_match');
    }
}
