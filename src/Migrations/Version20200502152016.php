<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502152016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('DROP TABLE rememberme_token');
        $this->addSql('ALTER TABLE paiement ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1EA76ED395 ON paiement (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rememberme_token (series CHAR(88) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, value CHAR(88) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, lastUsed DATETIME NOT NULL, class VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, username VARCHAR(200) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, UNIQUE INDEX series (series), PRIMARY KEY(series)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EA76ED395');
        $this->addSql('DROP INDEX IDX_B1DC7A1EA76ED395 ON paiement');
        $this->addSql('ALTER TABLE paiement DROP user_id');
    }
}
