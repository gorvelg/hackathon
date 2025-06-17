<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250617144124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE content (slug VARCHAR(255) NOT NULL, author_uid VARCHAR(36) NOT NULL, uid VARCHAR(36) NOT NULL, title VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_FEC530A9539B0606 (uid), INDEX IDX_FEC530A9B2DCD28A (author_uid), PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (uid VARCHAR(36) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(uid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE content ADD CONSTRAINT FK_FEC530A9B2DCD28A FOREIGN KEY (author_uid) REFERENCES user (uid)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9B2DCD28A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE content
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
