<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241212132738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restocking DROP FOREIGN KEY FK_9983191E642B8210');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D769B6B5FBA');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP INDEX IDX_9983191E642B8210 ON restocking');
        $this->addSql('ALTER TABLE restocking DROP admin_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, UNIQUE INDEX UNIQ_880E0D769B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D769B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE restocking ADD admin_id INT NOT NULL');
        $this->addSql('ALTER TABLE restocking ADD CONSTRAINT FK_9983191E642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_9983191E642B8210 ON restocking (admin_id)');
    }
}
