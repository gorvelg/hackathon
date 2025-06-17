<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250617125835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON content
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_FEC530A9539B0606 ON content (uid)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content ADD PRIMARY KEY (slug)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_FEC530A9539B0606 ON content
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON content
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content ADD PRIMARY KEY (uid)
        SQL);
    }
}
