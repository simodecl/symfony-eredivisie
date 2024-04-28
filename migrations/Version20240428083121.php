<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240428083121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE standing (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, position INT NOT NULL, played_games INT NOT NULL, won INT NOT NULL, draw INT NOT NULL, lost INT NOT NULL, points INT NOT NULL, goals_for INT NOT NULL, goals_against INT NOT NULL, UNIQUE INDEX UNIQ_619A8AD8296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE standing ADD CONSTRAINT FK_619A8AD8296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE standing DROP FOREIGN KEY FK_619A8AD8296CD8AE');
        $this->addSql('DROP TABLE standing');
    }
}
