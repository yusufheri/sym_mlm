<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429181312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bonus (id INT AUTO_INCREMENT NOT NULL, beneficiary_id INT NOT NULL, donor_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, paid_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_9F987F7AECCAAFA0 (beneficiary_id), INDEX IDX_9F987F7A3DD7B7A7 (donor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, payer_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, amount_letter VARCHAR(255) DEFAULT NULL, INDEX IDX_B1DC7A1E12469DE2 (category_id), INDEX IDX_B1DC7A1EC17AD9A9 (payer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bonus ADD CONSTRAINT FK_9F987F7AECCAAFA0 FOREIGN KEY (beneficiary_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE bonus ADD CONSTRAINT FK_9F987F7A3DD7B7A7 FOREIGN KEY (donor_id) REFERENCES paiement (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E12469DE2 FOREIGN KEY (category_id) REFERENCES cat_paiement (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EC17AD9A9 FOREIGN KEY (payer_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE cat_paiement ADD category_id INT DEFAULT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cat_paiement ADD CONSTRAINT FK_33F43F5D12469DE2 FOREIGN KEY (category_id) REFERENCES cat_member (id)');
        $this->addSql('CREATE INDEX IDX_33F43F5D12469DE2 ON cat_paiement (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bonus DROP FOREIGN KEY FK_9F987F7A3DD7B7A7');
        $this->addSql('DROP TABLE bonus');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('ALTER TABLE cat_paiement DROP FOREIGN KEY FK_33F43F5D12469DE2');
        $this->addSql('DROP INDEX IDX_33F43F5D12469DE2 ON cat_paiement');
        $this->addSql('ALTER TABLE cat_paiement DROP category_id, DROP updated_at');
    }
}
