<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827181023 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_imgs DROP FOREIGN KEY FK_FD442A181EDE0F55');
        $this->addSql('ALTER TABLE projects_dev_skills DROP FOREIGN KEY FK_409C2FF71EDE0F55');
        $this->addSql('DROP TABLE project_imgs');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE projects_dev_skills');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_imgs (id INT AUTO_INCREMENT NOT NULL, projects_id INT NOT NULL, link VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_FD442A181EDE0F55 (projects_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, technos_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, website VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5C93B3A425F7B143 (technos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projects_dev_skills (projects_id INT NOT NULL, dev_skills_id INT NOT NULL, INDEX IDX_409C2FF71EDE0F55 (projects_id), INDEX IDX_409C2FF7B6B8A4D1 (dev_skills_id), PRIMARY KEY(projects_id, dev_skills_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE project_imgs ADD CONSTRAINT FK_FD442A181EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A425F7B143 FOREIGN KEY (technos_id) REFERENCES technos (id)');
        $this->addSql('ALTER TABLE projects_dev_skills ADD CONSTRAINT FK_409C2FF71EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_dev_skills ADD CONSTRAINT FK_409C2FF7B6B8A4D1 FOREIGN KEY (dev_skills_id) REFERENCES dev_skills (id) ON DELETE CASCADE');
    }
}
