<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418124428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, day_check_id INT NOT NULL, hearth_id INT NOT NULL, name VARCHAR(255) NOT NULL, check_time VARCHAR(255) DEFAULT NULL, INDEX IDX_E5A0299073DDA29B (day_check_id), INDEX IDX_E5A029909952F797 (hearth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day_check (id INT AUTO_INCREMENT NOT NULL, resident_id INT NOT NULL, created_by_id INT NOT NULL, diet_id INT DEFAULT NULL, texture_id INT DEFAULT NULL, hearth_id INT NOT NULL, name VARCHAR(80) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_854310F78012C5B0 (resident_id), INDEX IDX_854310F7B03A8386 (created_by_id), INDEX IDX_854310F7E1E13ACE (diet_id), INDEX IDX_854310F7204BC3AC (texture_id), INDEX IDX_854310F79952F797 (hearth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diet (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, hearth_id INT NOT NULL, name VARCHAR(80) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_9DE46520B03A8386 (created_by_id), INDEX IDX_9DE465209952F797 (hearth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hearth (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone BIGINT DEFAULT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resident (id INT AUTO_INCREMENT NOT NULL, unity_id INT NOT NULL, created_by_id INT NOT NULL, hearth_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, room VARCHAR(255) NOT NULL, born_at DATETIME NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_1D03DA06F6859C8C (unity_id), INDEX IDX_1D03DA06B03A8386 (created_by_id), INDEX IDX_1D03DA069952F797 (hearth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE texture (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, hearth_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_82660D72B03A8386 (created_by_id), INDEX IDX_82660D729952F797 (hearth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unity (id INT AUTO_INCREMENT NOT NULL, hearth_id INT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_9659D579952F797 (hearth_id), INDEX IDX_9659D57B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, hearth_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, work VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6499952F797 (hearth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A0299073DDA29B FOREIGN KEY (day_check_id) REFERENCES day_check (id)');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A029909952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
        $this->addSql('ALTER TABLE day_check ADD CONSTRAINT FK_854310F78012C5B0 FOREIGN KEY (resident_id) REFERENCES resident (id)');
        $this->addSql('ALTER TABLE day_check ADD CONSTRAINT FK_854310F7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE day_check ADD CONSTRAINT FK_854310F7E1E13ACE FOREIGN KEY (diet_id) REFERENCES diet (id)');
        $this->addSql('ALTER TABLE day_check ADD CONSTRAINT FK_854310F7204BC3AC FOREIGN KEY (texture_id) REFERENCES texture (id)');
        $this->addSql('ALTER TABLE day_check ADD CONSTRAINT FK_854310F79952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE46520B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diet ADD CONSTRAINT FK_9DE465209952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
        $this->addSql('ALTER TABLE resident ADD CONSTRAINT FK_1D03DA06F6859C8C FOREIGN KEY (unity_id) REFERENCES unity (id)');
        $this->addSql('ALTER TABLE resident ADD CONSTRAINT FK_1D03DA06B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resident ADD CONSTRAINT FK_1D03DA069952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
        $this->addSql('ALTER TABLE texture ADD CONSTRAINT FK_82660D72B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE texture ADD CONSTRAINT FK_82660D729952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
        $this->addSql('ALTER TABLE unity ADD CONSTRAINT FK_9659D579952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
        $this->addSql('ALTER TABLE unity ADD CONSTRAINT FK_9659D57B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499952F797 FOREIGN KEY (hearth_id) REFERENCES hearth (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A0299073DDA29B');
        $this->addSql('ALTER TABLE day_check DROP FOREIGN KEY FK_854310F7E1E13ACE');
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A029909952F797');
        $this->addSql('ALTER TABLE day_check DROP FOREIGN KEY FK_854310F79952F797');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE465209952F797');
        $this->addSql('ALTER TABLE resident DROP FOREIGN KEY FK_1D03DA069952F797');
        $this->addSql('ALTER TABLE texture DROP FOREIGN KEY FK_82660D729952F797');
        $this->addSql('ALTER TABLE unity DROP FOREIGN KEY FK_9659D579952F797');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499952F797');
        $this->addSql('ALTER TABLE day_check DROP FOREIGN KEY FK_854310F78012C5B0');
        $this->addSql('ALTER TABLE day_check DROP FOREIGN KEY FK_854310F7204BC3AC');
        $this->addSql('ALTER TABLE resident DROP FOREIGN KEY FK_1D03DA06F6859C8C');
        $this->addSql('ALTER TABLE day_check DROP FOREIGN KEY FK_854310F7B03A8386');
        $this->addSql('ALTER TABLE diet DROP FOREIGN KEY FK_9DE46520B03A8386');
        $this->addSql('ALTER TABLE resident DROP FOREIGN KEY FK_1D03DA06B03A8386');
        $this->addSql('ALTER TABLE texture DROP FOREIGN KEY FK_82660D72B03A8386');
        $this->addSql('ALTER TABLE unity DROP FOREIGN KEY FK_9659D57B03A8386');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE day_check');
        $this->addSql('DROP TABLE diet');
        $this->addSql('DROP TABLE hearth');
        $this->addSql('DROP TABLE resident');
        $this->addSql('DROP TABLE texture');
        $this->addSql('DROP TABLE unity');
        $this->addSql('DROP TABLE user');
    }
}
