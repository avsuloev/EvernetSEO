<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722115101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, access_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_author (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', etxt_id INT NOT NULL, login VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, etxt_registered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', rating INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_multitasking (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', multitone_mode INT DEFAULT NULL, is_multitask INT DEFAULT NULL, multitasks_counted INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, cms_title LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_task (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', project_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', etxt_author_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', text_restraints_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', author_restraints_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', task_type_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', autoaccept_politic_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', multitasking_politic_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', task_filename VARCHAR(255) DEFAULT NULL, etxt_id INT DEFAULT NULL, is_publicised INT DEFAULT NULL, title LONGTEXT NOT NULL, task_description LONGTEXT DEFAULT NULL, task_text LONGTEXT DEFAULT NULL, price INT DEFAULT NULL, pricing_mode INT DEFAULT NULL, deadline_dd_mm_year VARCHAR(255) DEFAULT NULL, deadline_hh_mm VARCHAR(255) DEFAULT NULL, task_folder_id INT DEFAULT NULL, keywords VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5EAAC297166D1F9C (project_id), INDEX IDX_5EAAC2979756629A (etxt_author_id), INDEX IDX_5EAAC297837D6181 (text_restraints_id), INDEX IDX_5EAAC297CC0E639D (author_restraints_id), INDEX IDX_5EAAC297DAADA679 (task_type_id), INDEX IDX_5EAAC297485F88F7 (autoaccept_politic_id), INDEX IDX_5EAAC2974B7ABF70 (multitasking_politic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_task_text_restraints (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', unique_score INT DEFAULT NULL, place_on_site INT DEFAULT NULL, space_count_mode INT DEFAULT NULL, task_size_in_chars INT DEFAULT NULL, require90_percent_completion INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, cms_title LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_task_type (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', task_type_id INT DEFAULT NULL, task_subtype_id INT DEFAULT NULL, task_category_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, cms_title LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_tasks_author_restraints (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', require_skill_check INT DEFAULT NULL, whitelist_mode INT DEFAULT NULL, whitelist_id INT DEFAULT NULL, notify_whitelisted INT DEFAULT NULL, is_certified_only INT DEFAULT NULL, is_graduated_only INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, cms_title LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etxt_tasks_auto_accept (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', auto_accept INT DEFAULT NULL, auto_accept_min_rating INT DEFAULT NULL, auto_accept_min_positive_reviews INT DEFAULT NULL, auto_accept_max_negative_reviews INT DEFAULT NULL, auto_accept_allowed_skill_lvl INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, cms_title LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', keyword_group_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, is_approved TINYINT(1) NOT NULL, position INT DEFAULT NULL, frequency INT DEFAULT NULL, client_note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5A93713B6F3F1416 (keyword_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE keyword_group (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', project_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_83297364166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE linked_key_groups (group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', linked_group_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', INDEX IDX_6C90036BFE54D947 (group_id), INDEX IDX_6C90036B90549798 (linked_group_id), PRIMARY KEY(group_id, linked_group_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', client_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', tv_id VARCHAR(255) DEFAULT NULL, ym_id VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, cms_title LONGTEXT NOT NULL, INDEX IDX_2FB3D0EE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ymreport_source (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', json_data JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ymreport_visits (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', json_data JSON NOT NULL, visits INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC297166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC2979756629A FOREIGN KEY (etxt_author_id) REFERENCES etxt_author (id)');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC297837D6181 FOREIGN KEY (text_restraints_id) REFERENCES etxt_task_text_restraints (id)');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC297CC0E639D FOREIGN KEY (author_restraints_id) REFERENCES etxt_tasks_author_restraints (id)');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC297DAADA679 FOREIGN KEY (task_type_id) REFERENCES etxt_task_type (id)');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC297485F88F7 FOREIGN KEY (autoaccept_politic_id) REFERENCES etxt_tasks_auto_accept (id)');
        $this->addSql('ALTER TABLE etxt_task ADD CONSTRAINT FK_5EAAC2974B7ABF70 FOREIGN KEY (multitasking_politic_id) REFERENCES etxt_multitasking (id)');
        $this->addSql('ALTER TABLE keyword ADD CONSTRAINT FK_5A93713B6F3F1416 FOREIGN KEY (keyword_group_id) REFERENCES keyword_group (id)');
        $this->addSql('ALTER TABLE keyword_group ADD CONSTRAINT FK_83297364166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE linked_key_groups ADD CONSTRAINT FK_6C90036BFE54D947 FOREIGN KEY (group_id) REFERENCES keyword_group (id)');
        $this->addSql('ALTER TABLE linked_key_groups ADD CONSTRAINT FK_6C90036B90549798 FOREIGN KEY (linked_group_id) REFERENCES keyword_group (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE19EB6921');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC2979756629A');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC2974B7ABF70');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC297837D6181');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC297DAADA679');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC297CC0E639D');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC297485F88F7');
        $this->addSql('ALTER TABLE keyword DROP FOREIGN KEY FK_5A93713B6F3F1416');
        $this->addSql('ALTER TABLE linked_key_groups DROP FOREIGN KEY FK_6C90036BFE54D947');
        $this->addSql('ALTER TABLE linked_key_groups DROP FOREIGN KEY FK_6C90036B90549798');
        $this->addSql('ALTER TABLE etxt_task DROP FOREIGN KEY FK_5EAAC297166D1F9C');
        $this->addSql('ALTER TABLE keyword_group DROP FOREIGN KEY FK_83297364166D1F9C');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE etxt_author');
        $this->addSql('DROP TABLE etxt_multitasking');
        $this->addSql('DROP TABLE etxt_task');
        $this->addSql('DROP TABLE etxt_task_text_restraints');
        $this->addSql('DROP TABLE etxt_task_type');
        $this->addSql('DROP TABLE etxt_tasks_author_restraints');
        $this->addSql('DROP TABLE etxt_tasks_auto_accept');
        $this->addSql('DROP TABLE keyword');
        $this->addSql('DROP TABLE keyword_group');
        $this->addSql('DROP TABLE linked_key_groups');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE ymreport_source');
        $this->addSql('DROP TABLE ymreport_visits');
    }
}
