<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210811115029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keyword (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', keyword_group_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, is_approved TINYINT(1) NOT NULL, position INT DEFAULT NULL, frequency INT DEFAULT NULL, client_note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5A93713B6F3F1416 (keyword_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', project_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', tree_root BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', parent_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, lvl INT NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, INDEX IDX_83297364166D1F9C (project_id), INDEX IDX_83297364A977936C (tree_root), INDEX IDX_83297364727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE keyword ADD CONSTRAINT FK_5A93713B6F3F1416 FOREIGN KEY (keyword_group_id) REFERENCES keyword_group (id)');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364A977936C FOREIGN KEY (tree_root) REFERENCES keyword_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364727ACA70 FOREIGN KEY (parent_id) REFERENCES keyword_group (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keyword DROP FOREIGN KEY FK_5A93713B6F3F1416');
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364A977936C');
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364727ACA70');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE keyword_group');
    }
}
