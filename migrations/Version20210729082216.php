<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729082216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE linked_key_groups');
        $this->addSql('ALTER TABLE keyword_group ADD supergroup_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\'');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364386CD096 FOREIGN KEY (supergroup_id) REFERENCES keyword_group (id)');
        $this->addSql('CREATE INDEX IDX_83297364386CD096 ON keyword_group (supergroup_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE linked_key_groups (group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', linked_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', INDEX IDX_6C90036B90549798 (linked_group_id), INDEX IDX_6C90036BFE54D947 (group_id), PRIMARY KEY(group_id, linked_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE linked_key_groups ADD CONSTRAINT FK_6C90036B90549798 FOREIGN KEY (linked_group_id) REFERENCES keyword_group (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE linked_key_groups ADD CONSTRAINT FK_6C90036BFE54D947 FOREIGN KEY (group_id) REFERENCES keyword_group (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364386CD096');
        $this->addSql('DROP INDEX IDX_83297364386CD096 ON keyword_group');
        $this->addSql('ALTER TABLE keyword_group DROP supergroup_id');
    }
}
