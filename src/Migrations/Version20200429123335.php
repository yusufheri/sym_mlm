<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429123335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7812469DE2 FOREIGN KEY (category_id) REFERENCES cat_member (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA7812469DE2 ON member (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7812469DE2');
        $this->addSql('DROP INDEX IDX_70E4FA7812469DE2 ON member');
        $this->addSql('ALTER TABLE member DROP category_id');
    }
}
