<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200822161753 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dev_skills (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_imgs (id INT AUTO_INCREMENT NOT NULL, projects_id INT NOT NULL, link VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_FD442A181EDE0F55 (projects_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, technos_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, website VARCHAR(255) NOT NULL, INDEX IDX_5C93B3A425F7B143 (technos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technos (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_imgs ADD CONSTRAINT FK_FD442A181EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A425F7B143 FOREIGN KEY (technos_id) REFERENCES technos (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_imgs DROP FOREIGN KEY FK_FD442A181EDE0F55');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A425F7B143');
        $this->addSql('DROP TABLE dev_skills');
        $this->addSql('DROP TABLE project_imgs');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE technos');
    }
}
