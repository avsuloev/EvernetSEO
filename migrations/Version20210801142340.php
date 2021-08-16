<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210801142340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364386CD096');
        $this->addSql('DROP INDEX IDX_83297364386CD096 ON keyword_group');
        $this->addSql('ALTER TABLE keyword_group ADD parent_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', ADD lvl INT NOT NULL, ADD rgt INT NOT NULL, CHANGE supergroup_id tree_root BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', CHANGE nesting_lvl lft INT NOT NULL');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364A977936C FOREIGN KEY (tree_root) REFERENCES keyword_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364727ACA70 FOREIGN KEY (parent_id) REFERENCES keyword_group (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_83297364A977936C ON keyword_group (tree_root)');
        $this->addSql('CREATE INDEX IDX_83297364727ACA70 ON keyword_group (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364A977936C');
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364727ACA70');
        $this->addSql('DROP INDEX IDX_83297364A977936C ON keyword_group');
        $this->addSql('DROP INDEX IDX_83297364727ACA70 ON keyword_group');
        $this->addSql('ALTER TABLE keyword_group ADD supergroup_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', ADD nesting_lvl INT NOT NULL, DROP tree_root, DROP parent_id, DROP lft, DROP lvl, DROP rgt');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364386CD096 FOREIGN KEY (supergroup_id) REFERENCES keyword_group (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_83297364386CD096 ON keyword_group (supergroup_id)');
    }
}
