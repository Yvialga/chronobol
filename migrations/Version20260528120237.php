<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260528120237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE runner CHANGE gender gender VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE team CHANGE category category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trail DROP INDEX IDX_B268858F2517F66D, ADD UNIQUE INDEX UNIQ_B268858F2517F66D (fk_trail_template_id)');
        $this->addSql('ALTER TABLE trail CHANGE fk_trail_template_id fk_trail_template_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE runner CHANGE gender gender INT NOT NULL');
        $this->addSql('ALTER TABLE team CHANGE category category INT NOT NULL');
        $this->addSql('ALTER TABLE trail DROP INDEX UNIQ_B268858F2517F66D, ADD INDEX IDX_B268858F2517F66D (fk_trail_template_id)');
        $this->addSql('ALTER TABLE trail CHANGE fk_trail_template_id fk_trail_template_id INT DEFAULT NULL');
    }
}
