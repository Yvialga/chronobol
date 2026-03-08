<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260308184447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD name VARCHAR(255) NOT NULL, ADD date DATE DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP event_name, DROP event_date, DROP event_slug');
        $this->addSql('ALTER TABLE runner ADD email VARCHAR(255) DEFAULT NULL, ADD is_validate TINYINT(1) NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP license, CHANGE age age DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE gender gender INT NOT NULL, CHANGE medical_certificate medical_certificate LONGTEXT NOT NULL, CHANGE parentale_consent parentale_consent TINYINT(1) NOT NULL, CHANGE personal_time personal_time DATETIME DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_F92B8B3EA6590BAB ON runner (bib_number)');
        $this->addSql('CREATE INDEX IDX_F92B8B3EA588ADB3 ON runner (chip_id)');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F43DFAB55');
        $this->addSql('DROP INDEX IDX_C4E0A61F43DFAB55 ON team');
        $this->addSql('ALTER TABLE team ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE paid_registration paid_registration TINYINT(1) NOT NULL, CHANGE deposit deposit TINYINT(1) NOT NULL, CHANGE electric_bike electric_bike TINYINT(1) NOT NULL, CHANGE meal_count meal_count INT NOT NULL, CHANGE final_time final_time DATETIME DEFAULT NULL, CHANGE fk_event_id category INT NOT NULL');
        $this->addSql('ALTER TABLE trail ADD fk_trail_template_id_id INT DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE trail_name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858FE77B5E9A FOREIGN KEY (fk_trail_template_id_id) REFERENCES trail_template (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B268858FE77B5E9A ON trail (fk_trail_template_id_id)');
        $this->addSql('ALTER TABLE user ADD email VARCHAR(180) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858FE77B5E9A');
        $this->addSql('DROP TABLE trail_template');
        $this->addSql('DROP INDEX IDX_F92B8B3EA6590BAB ON runner');
        $this->addSql('DROP INDEX IDX_F92B8B3EA588ADB3 ON runner');
        $this->addSql('ALTER TABLE runner ADD license TINYINT(1) DEFAULT NULL, DROP email, DROP is_validate, DROP status, DROP created_at, DROP updated_at, CHANGE age age INT NOT NULL, CHANGE gender gender SMALLINT NOT NULL, CHANGE medical_certificate medical_certificate TINYINT(1) NOT NULL, CHANGE parentale_consent parentale_consent TINYINT(1) DEFAULT NULL, CHANGE personal_time personal_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE team DROP created_at, DROP updated_at, CHANGE paid_registration paid_registration TINYINT(1) DEFAULT NULL, CHANGE final_time final_time TIME DEFAULT NULL, CHANGE deposit deposit TINYINT(1) DEFAULT NULL, CHANGE electric_bike electric_bike TINYINT(1) DEFAULT NULL, CHANGE meal_count meal_count INT DEFAULT NULL, CHANGE category fk_event_id INT NOT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F43DFAB55 FOREIGN KEY (fk_event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C4E0A61F43DFAB55 ON team (fk_event_id)');
        $this->addSql('ALTER TABLE event ADD event_name VARCHAR(255) NOT NULL, ADD event_date DATE NOT NULL, ADD event_slug VARCHAR(255) NOT NULL, DROP name, DROP date, DROP slug, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP email, DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_B268858FE77B5E9A ON trail');
        $this->addSql('ALTER TABLE trail DROP fk_trail_template_id_id, DROP description, DROP created_at, DROP updated_at, CHANGE name trail_name VARCHAR(255) NOT NULL');
    }
}
