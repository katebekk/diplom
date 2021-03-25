<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325035106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD difficulty_level VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3591CC992 ON lesson (course_id)');
        $this->addSql('ALTER TABLE lesson_stage ADD lesson_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson_stage ADD CONSTRAINT FK_889A47EECDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_889A47EECDF80196 ON lesson_stage (lesson_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP difficulty_level');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3591CC992');
        $this->addSql('DROP INDEX IDX_F87474F3591CC992 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP course_id');
        $this->addSql('ALTER TABLE lesson_stage DROP FOREIGN KEY FK_889A47EECDF80196');
        $this->addSql('DROP INDEX IDX_889A47EECDF80196 ON lesson_stage');
        $this->addSql('ALTER TABLE lesson_stage DROP lesson_id');
    }
}
