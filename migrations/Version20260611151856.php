<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260611151856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE date date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE runner CHANGE personal_time personal_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE team CHANGE final_time final_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE trail ADD run_state VARCHAR(255) NOT NULL, CHANGE start_time start_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE date date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE runner CHANGE personal_time personal_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE trail DROP run_state, CHANGE start_time start_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE team CHANGE final_time final_time DATETIME DEFAULT NULL');
    }
}
