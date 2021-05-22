<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522132732 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE collections DROP comments, CHANGE users_id users_id INT NOT NULL');
        // $this->addSql('ALTER TABLE comments ADD users_id_id INT NOT NULL');
        // $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A98333A1E FOREIGN KEY (users_id_id) REFERENCES users (id)');
        // $this->addSql('CREATE INDEX IDX_5F9E962A98333A1E ON comments (users_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
         //$this->addSql('ALTER TABLE collections ADD comments VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE users_id users_id INT DEFAULT NULL');
         $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A98333A1E');
         $this->addSql('DROP INDEX IDX_5F9E962A98333A1E ON comments');
         $this->addSql('ALTER TABLE comments DROP users_id_id');
    }
}
