<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250617131704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE content ADD author_uid VARCHAR(36) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content ADD CONSTRAINT FK_FEC530A9B2DCD28A FOREIGN KEY (author_uid) REFERENCES user (uid)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_FEC530A9B2DCD28A ON content (author_uid)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9B2DCD28A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_FEC530A9B2DCD28A ON content
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content DROP author_uid
        SQL);
    }
}
