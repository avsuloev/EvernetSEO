<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702132542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE linked_key_groups (group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', linked_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', INDEX IDX_6C90036BFE54D947 (group_id), INDEX IDX_6C90036B90549798 (linked_group_id), PRIMARY KEY(group_id, linked_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE linked_key_groups ADD CONSTRAINT FK_6C90036BFE54D947 FOREIGN KEY (group_id) REFERENCES keyword_group (id)');
        $this->addSql('ALTER TABLE linked_key_groups ADD CONSTRAINT FK_6C90036B90549798 FOREIGN KEY (linked_group_id) REFERENCES keyword_group (id)');
        $this->addSql('DROP TABLE keyword_group_keyword_group');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE keyword_group_keyword_group (keyword_group_source BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', keyword_group_target BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', INDEX IDX_D5AD91C567CBDBC9 (keyword_group_source), INDEX IDX_D5AD91C57E2E8B46 (keyword_group_target), PRIMARY KEY(keyword_group_source, keyword_group_target)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE keyword_group_keyword_group ADD CONSTRAINT FK_D5AD91C567CBDBC9 FOREIGN KEY (keyword_group_source) REFERENCES keyword_group (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE keyword_group_keyword_group ADD CONSTRAINT FK_D5AD91C57E2E8B46 FOREIGN KEY (keyword_group_target) REFERENCES keyword_group (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE linked_key_groups');
    }
}
