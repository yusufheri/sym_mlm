<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429083751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member ADD parrain_id INT DEFAULT NULL, ADD lastname VARCHAR(255) DEFAULT NULL, ADD prename VARCHAR(255) DEFAULT NULL, ADD address LONGTEXT NOT NULL, ADD token VARCHAR(15) NOT NULL, DROP postnom, DROP prenom, CHANGE nom name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78DE2A7A37 FOREIGN KEY (parrain_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78DE2A7A37 ON member (parrain_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78DE2A7A37');
        $this->addSql('DROP INDEX IDX_70E4FA78DE2A7A37 ON member');
        $this->addSql('ALTER TABLE member ADD postnom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP parrain_id, DROP lastname, DROP prename, DROP address, DROP token, CHANGE name nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
