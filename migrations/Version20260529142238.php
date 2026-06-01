<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260529142238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE runner (id INT AUTO_INCREMENT NOT NULL, fk_team_id INT DEFAULT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, age DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', gender VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, bib_number INT DEFAULT NULL, chip_id BIGINT DEFAULT NULL, is_captain TINYINT(1) NOT NULL, is_underage TINYINT(1) NOT NULL, medical_certificate LONGTEXT NOT NULL, parental_consent TINYINT(1) NOT NULL, personal_time DATETIME DEFAULT NULL, is_validate TINYINT(1) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F92B8B3EA6590BAB (bib_number), UNIQUE INDEX UNIQ_F92B8B3EA588ADB3 (chip_id), INDEX IDX_F92B8B3EA588ADB3 (chip_id), INDEX IDX_F92B8B3ED943E582 (fk_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, fk_trail_id INT NOT NULL, category VARCHAR(255) NOT NULL, paid_registration TINYINT(1) NOT NULL, final_time DATETIME DEFAULT NULL, deposit TINYINT(1) NOT NULL, electric_bike TINYINT(1) NOT NULL, meal_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4E0A61FBB9D5F85 (fk_trail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trail (id INT AUTO_INCREMENT NOT NULL, fk_event_id INT NOT NULL, fk_trail_template_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, start_time DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, member_number INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B268858F43DFAB55 (fk_event_id), INDEX IDX_B268858F2517F66D (fk_trail_template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trail_template (id INT AUTO_INCREMENT NOT NULL, model_name VARCHAR(255) NOT NULL, min_age INT NOT NULL, max_age INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE runner ADD CONSTRAINT FK_F92B8B3ED943E582 FOREIGN KEY (fk_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FBB9D5F85 FOREIGN KEY (fk_trail_id) REFERENCES trail (id)');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858F43DFAB55 FOREIGN KEY (fk_event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858F2517F66D FOREIGN KEY (fk_trail_template_id) REFERENCES trail_template (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE runner DROP FOREIGN KEY FK_F92B8B3ED943E582');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FBB9D5F85');
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858F43DFAB55');
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858F2517F66D');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE runner');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE trail');
        $this->addSql('DROP TABLE trail_template');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
