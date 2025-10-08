<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512072900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, fk_space_id INT NOT NULL, event_name VARCHAR(255) NOT NULL, event_date DATE NOT NULL, event_slug VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA71BB42E27 (fk_space_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE runner (id INT AUTO_INCREMENT NOT NULL, fk_team_id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, age INT NOT NULL, gender SMALLINT NOT NULL, bib_number INT NOT NULL, chip_id BIGINT DEFAULT NULL, is_captain TINYINT(1) NOT NULL, is_underage TINYINT(1) NOT NULL, license TINYINT(1) DEFAULT NULL, medical_certificate TINYINT(1) NOT NULL, parentale_consent TINYINT(1) DEFAULT NULL, personal_time TIME DEFAULT NULL, UNIQUE INDEX UNIQ_F92B8B3EA588ADB3 (chip_id), INDEX IDX_F92B8B3E482C1D84 (fk_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE space (id INT AUTO_INCREMENT NOT NULL, space_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_SPACE_NAME (space_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, fk_event_id INT NOT NULL, fk_trail_id INT NOT NULL, paid_registration TINYINT(1) DEFAULT NULL, deposit TINYINT(1) DEFAULT NULL, electric_bike TINYINT(1) DEFAULT NULL, meal_count INT DEFAULT NULL, member_number INT NOT NULL, final_time TIME DEFAULT NULL, INDEX IDX_C4E0A61F57A9834F (fk_event_id), INDEX IDX_C4E0A61F3222B282 (fk_trail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE trail (id INT AUTO_INCREMENT NOT NULL, fk_event_id INT NOT NULL, trail_name VARCHAR(255) NOT NULL, start_time DATETIME DEFAULT NULL, INDEX IDX_B268858F57A9834F (fk_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, fk_space_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), INDEX IDX_CEM89LP983JUI55L (fk_space_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71BB42E27 FOREIGN KEY (fk_space_id) REFERENCES space (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE runner ADD CONSTRAINT FK_F92B8B3E482C1D84 FOREIGN KEY (fk_team_id) REFERENCES team (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F57A9834F FOREIGN KEY (fk_event_id) REFERENCES event (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3222B282 FOREIGN KEY (fk_trail_id) REFERENCES trail (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trail ADD CONSTRAINT FK_B268858F57A9834F FOREIGN KEY (fk_event_id) REFERENCES event (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_CEM89LP983JUI55L FOREIGN KEY (fk_space_name) REFERENCES space (space_name)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71BB42E27
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE runner DROP FOREIGN KEY FK_F92B8B3E482C1D84
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F57A9834F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3222B282
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trail DROP FOREIGN KEY FK_B268858F57A9834F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE runner
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE space
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE team
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE trail
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
