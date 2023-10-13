<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230909114206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE `message_author` (
                id INT AUTO_INCREMENT NOT NULL, 
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB;

            ALTER TABLE `message`
                ADD COLUMN author_id INT NULL;

            ALTER TABLE `message`
                ADD CONSTRAINT fk_message_message_author_1 
                    FOREIGN KEY (author_id) REFERENCES `message_author` (id)
                        ON UPDATE CASCADE ON DELETE SET NULL,
                ADD CONSTRAINT unique_author_1
                    UNIQUE (author_id);

            CREATE TABLE `tag` (
                id INT AUTO_INCREMENT NOT NULL, 
                label VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB;

            CREATE TABLE `message_has_tag` (
                message_id INT NOT NULL, 
                tag_id INT NOT NULL,
                PRIMARY KEY(message_id,tag_id)
            ) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` 
            ENGINE = InnoDB;

            ALTER TABLE `message_has_tag`
                ADD CONSTRAINT fk_message_has_tag_message1 
                    FOREIGN KEY (message_id) REFERENCES `message` (id)
                        ON UPDATE CASCADE ON DELETE CASCADE,
                ADD CONSTRAINT fk_message_has_tag_tag1 
                    FOREIGN KEY (tag_id) REFERENCES `tag` (id)
                        ON UPDATE CASCADE ON DELETE CASCADE;

        ');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
