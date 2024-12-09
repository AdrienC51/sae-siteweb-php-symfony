<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209184148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, UNIQUE INDEX UNIQ_880E0D769B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(300) DEFAULT NULL, picture LONGBLOB DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_key_word (article_id INT NOT NULL, key_word_id INT NOT NULL, INDEX IDX_101E5AB37294869C (article_id), INDEX IDX_101E5AB3818167B3 (key_word_id), PRIMARY KEY(article_id, key_word_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_category (article_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_53A4EDAA7294869C (article_id), INDEX IDX_53A4EDAA12469DE2 (category_id), PRIMARY KEY(article_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_line (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, article_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_3EF1B4CF1AD5CDBF (cart_id), INDEX IDX_3EF1B4CF7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, cart_id INT DEFAULT NULL, address VARCHAR(200) DEFAULT NULL, post_code VARCHAR(5) DEFAULT NULL, city VARCHAR(128) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, UNIQUE INDEX UNIQ_C74404559B6B5FBA (account_id), UNIQUE INDEX UNIQ_C74404551AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, delivery_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE key_word (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, delivery_id INT DEFAULT NULL, order_date DATE DEFAULT NULL, dest_address VARCHAR(200) NOT NULL, dest_post_code VARCHAR(5) NOT NULL, dest_city VARCHAR(128) NOT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_F529939819EB6921 (client_id), INDEX IDX_F529939812136921 (delivery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, related_order_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_9CE58EE17294869C (article_id), INDEX IDX_9CE58EE12B1C2395 (related_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restocking (id INT AUTO_INCREMENT NOT NULL, admin_id INT NOT NULL, restock_date DATE DEFAULT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_9983191E642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restocking_line (id INT AUTO_INCREMENT NOT NULL, restocking_id INT NOT NULL, article_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_3D0061919F483051 (restocking_id), INDEX IDX_3D0061917294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_evolution (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, quantity INT NOT NULL, type VARCHAR(3) NOT NULL, evolution_date DATE NOT NULL, INDEX IDX_DA91CE7B7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, entry_date DATE NOT NULL, expiration_date DATE NOT NULL, INDEX IDX_DCBB0C537294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D769B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE article_key_word ADD CONSTRAINT FK_101E5AB37294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_key_word ADD CONSTRAINT FK_101E5AB3818167B3 FOREIGN KEY (key_word_id) REFERENCES key_word (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAA7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CF7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404559B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404551AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939812136921 FOREIGN KEY (delivery_id) REFERENCES delivery (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE17294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE12B1C2395 FOREIGN KEY (related_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE restocking ADD CONSTRAINT FK_9983191E642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE restocking_line ADD CONSTRAINT FK_3D0061919F483051 FOREIGN KEY (restocking_id) REFERENCES restocking (id)');
        $this->addSql('ALTER TABLE restocking_line ADD CONSTRAINT FK_3D0061917294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE stock_evolution ADD CONSTRAINT FK_DA91CE7B7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C537294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D769B6B5FBA');
        $this->addSql('ALTER TABLE article_key_word DROP FOREIGN KEY FK_101E5AB37294869C');
        $this->addSql('ALTER TABLE article_key_word DROP FOREIGN KEY FK_101E5AB3818167B3');
        $this->addSql('ALTER TABLE article_category DROP FOREIGN KEY FK_53A4EDAA7294869C');
        $this->addSql('ALTER TABLE article_category DROP FOREIGN KEY FK_53A4EDAA12469DE2');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF1AD5CDBF');
        $this->addSql('ALTER TABLE cart_line DROP FOREIGN KEY FK_3EF1B4CF7294869C');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404559B6B5FBA');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404551AD5CDBF');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939819EB6921');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939812136921');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE17294869C');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE12B1C2395');
        $this->addSql('ALTER TABLE restocking DROP FOREIGN KEY FK_9983191E642B8210');
        $this->addSql('ALTER TABLE restocking_line DROP FOREIGN KEY FK_3D0061919F483051');
        $this->addSql('ALTER TABLE restocking_line DROP FOREIGN KEY FK_3D0061917294869C');
        $this->addSql('ALTER TABLE stock_evolution DROP FOREIGN KEY FK_DA91CE7B7294869C');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C537294869C');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_key_word');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_line');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE key_word');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE restocking');
        $this->addSql('DROP TABLE restocking_line');
        $this->addSql('DROP TABLE stock_evolution');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
