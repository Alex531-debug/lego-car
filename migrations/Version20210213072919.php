<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213072919 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auto (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, price NUMERIC(10, 2) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_66BA25FA44F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auto_image (auto_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_CCB86BA41D55B925 (auto_id), INDEX IDX_CCB86BA43DA5256D (image_id), PRIMARY KEY(auto_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(500) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auto ADD CONSTRAINT FK_66BA25FA44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE auto_image ADD CONSTRAINT FK_CCB86BA41D55B925 FOREIGN KEY (auto_id) REFERENCES auto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auto_image ADD CONSTRAINT FK_CCB86BA43DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auto_image DROP FOREIGN KEY FK_CCB86BA41D55B925');
        $this->addSql('ALTER TABLE auto DROP FOREIGN KEY FK_66BA25FA44F5D008');
        $this->addSql('ALTER TABLE auto_image DROP FOREIGN KEY FK_CCB86BA43DA5256D');
        $this->addSql('DROP TABLE auto');
        $this->addSql('DROP TABLE auto_image');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE image');
    }
}
