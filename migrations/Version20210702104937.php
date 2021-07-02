<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702104937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin_1');
        $this->addSql('ALTER TABLE etxt_multitasking ADD cms_title LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE etxt_task_text_restraints ADD cms_title LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE etxt_task_type ADD cms_title LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE etxt_tasks_author_restraints ADD cms_title LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE etxt_tasks_auto_accept ADD cms_title LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_1 (id INT DEFAULT NULL, username VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, roles JSON DEFAULT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE etxt_multitasking DROP cms_title');
        $this->addSql('ALTER TABLE etxt_task_text_restraints DROP cms_title');
        $this->addSql('ALTER TABLE etxt_task_type DROP cms_title');
        $this->addSql('ALTER TABLE etxt_tasks_author_restraints DROP cms_title');
        $this->addSql('ALTER TABLE etxt_tasks_auto_accept DROP cms_title');
    }
}
