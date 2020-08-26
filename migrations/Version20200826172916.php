<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826172916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projects_dev_skills (projects_id INT NOT NULL, dev_skills_id INT NOT NULL, INDEX IDX_409C2FF71EDE0F55 (projects_id), INDEX IDX_409C2FF7B6B8A4D1 (dev_skills_id), PRIMARY KEY(projects_id, dev_skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects_dev_skills ADD CONSTRAINT FK_409C2FF71EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_dev_skills ADD CONSTRAINT FK_409C2FF7B6B8A4D1 FOREIGN KEY (dev_skills_id) REFERENCES dev_skills (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE projects_dev_skills');
    }
}
