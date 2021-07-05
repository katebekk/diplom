<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624004013 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drawing_check_result (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, lesson_stage_id INT NOT NULL, result_image VARCHAR(255) NOT NULL, result_message VARCHAR(500) NOT NULL, INDEX IDX_BF2B0C36A76ED395 (user_id), INDEX IDX_BF2B0C366ADF9B8A (lesson_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reference (id INT AUTO_INCREMENT NOT NULL, drawing_image VARCHAR(255) NOT NULL, rule VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drawing_check_result ADD CONSTRAINT FK_BF2B0C36A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE drawing_check_result ADD CONSTRAINT FK_BF2B0C366ADF9B8A FOREIGN KEY (lesson_stage_id) REFERENCES lesson_stage (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE drawing_check_result');
        $this->addSql('DROP TABLE reference');
    }
}
