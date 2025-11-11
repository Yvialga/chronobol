<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514070105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE team RENAME INDEX idx_c4e0a61f57a9834f TO IDX_C4E0A61F43DFAB55
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team RENAME INDEX idx_c4e0a61f3222b282 TO IDX_C4E0A61FBB9D5F85
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trail RENAME INDEX idx_b268858f57a9834f TO IDX_B268858F43DFAB55
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_CEM89LP983JUI55L
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE fk_space_name fk_space_name INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649C53BCE1F FOREIGN KEY (fk_space_name) REFERENCES space (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX idx_cem89lp983jui55l TO IDX_8D93D649C53BCE1F
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F43DFAB55
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trail DROP FOREIGN KEY FK_B268858F43DFAB55
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7117F109E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE runner DROP FOREIGN KEY FK_F92B8B3ED943E582
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE runner
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C53BCE1F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE fk_space_name fk_space_name VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_CEM89LP983JUI55L FOREIGN KEY (fk_space_name) REFERENCES space (space_name) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user RENAME INDEX idx_8d93d649c53bce1f TO IDX_CEM89LP983JUI55L
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trail RENAME INDEX idx_b268858f43dfab55 TO IDX_B268858F57A9834F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FBB9D5F85
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team RENAME INDEX idx_c4e0a61f43dfab55 TO IDX_C4E0A61F57A9834F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE team RENAME INDEX idx_c4e0a61fbb9d5f85 TO IDX_C4E0A61F3222B282
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_SPACE_NAME ON space (space_name)
        SQL);
    }
}
