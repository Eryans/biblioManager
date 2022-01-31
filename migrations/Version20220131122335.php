<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131122335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX id ON book');
        $this->addSql('ALTER TABLE book CHANGE summary summary VARCHAR(400) DEFAULT NULL, CHANGE release_date release_date DATE DEFAULT NULL, CHANGE available available TINYINT(1) NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE book RENAME INDEX fk_client_id TO IDX_CBE5A33119EB6921');
        $this->addSql('DROP INDEX mail ON client');
        $this->addSql('DROP INDEX phone ON client');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE book MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE book DROP INDEX primary, ADD UNIQUE INDEX id (id)');
        $this->addSql('ALTER TABLE book CHANGE title title VARCHAR(100) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE author author VARCHAR(100) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE summary summary VARCHAR(400) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE release_date release_date DATE NOT NULL, CHANGE category category VARCHAR(50) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE available available TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE book RENAME INDEX idx_cbe5a33119eb6921 TO FK_client_id');
        $this->addSql('ALTER TABLE client CHANGE first_name first_name VARCHAR(50) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE last_name last_name VARCHAR(50) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE adress adress VARCHAR(95) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE city city VARCHAR(35) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE mail mail VARCHAR(62) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE phone phone VARCHAR(15) NOT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('CREATE UNIQUE INDEX mail ON client (mail)');
        $this->addSql('CREATE UNIQUE INDEX phone ON client (phone)');
    }
}
