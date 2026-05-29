<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260529135151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE runner CHANGE fk_team_id fk_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team DROP member_number');
        $this->addSql('ALTER TABLE trail ADD member_number INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE runner CHANGE fk_team_id fk_team_id INT NOT NULL');
        $this->addSql('ALTER TABLE team ADD member_number INT NOT NULL');
        $this->addSql('ALTER TABLE trail DROP member_number');
    }
}
