<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319093048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858FE77B5E9A');
        $this->addSql('DROP INDEX UNIQ_B268858FE77B5E9A ON trail');
        $this->addSql('ALTER TABLE trail CHANGE fk_trail_template_id_id fk_trail_template_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858F2517F66D FOREIGN KEY (fk_trail_template_id) REFERENCES trail_template (id)');
        $this->addSql('CREATE INDEX IDX_B268858F2517F66D ON trail (fk_trail_template_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trail DROP FOREIGN KEY FK_B268858F2517F66D');
        $this->addSql('DROP INDEX IDX_B268858F2517F66D ON trail');
        $this->addSql('ALTER TABLE trail CHANGE fk_trail_template_id fk_trail_template_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trail ADD CONSTRAINT FK_B268858FE77B5E9A FOREIGN KEY (fk_trail_template_id_id) REFERENCES trail_template (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B268858FE77B5E9A ON trail (fk_trail_template_id_id)');
    }
}
