<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624004334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference ADD lesson_stage_id INT NOT NULL');
        $this->addSql('ALTER TABLE reference ADD CONSTRAINT FK_AEA349136ADF9B8A FOREIGN KEY (lesson_stage_id) REFERENCES lesson_stage (id)');
        $this->addSql('CREATE INDEX IDX_AEA349136ADF9B8A ON reference (lesson_stage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference DROP FOREIGN KEY FK_AEA349136ADF9B8A');
        $this->addSql('DROP INDEX IDX_AEA349136ADF9B8A ON reference');
        $this->addSql('ALTER TABLE reference DROP lesson_stage_id');
    }
}
