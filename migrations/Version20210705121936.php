<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705121936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE passing (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1AFA04BA591CC992 (course_id), INDEX IDX_1AFA04BAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE passing ADD CONSTRAINT FK_1AFA04BA591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE passing ADD CONSTRAINT FK_1AFA04BAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE drawing_check_result ADD passing_id INT NOT NULL');
        $this->addSql('ALTER TABLE drawing_check_result ADD CONSTRAINT FK_BF2B0C36978C60EA FOREIGN KEY (passing_id) REFERENCES passing (id)');
        $this->addSql('CREATE INDEX IDX_BF2B0C36978C60EA ON drawing_check_result (passing_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drawing_check_result DROP FOREIGN KEY FK_BF2B0C36978C60EA');
        $this->addSql('DROP TABLE passing');
        $this->addSql('DROP INDEX IDX_BF2B0C36978C60EA ON drawing_check_result');
        $this->addSql('ALTER TABLE drawing_check_result DROP passing_id');
    }
}
