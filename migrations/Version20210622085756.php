<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622085756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board_post (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_801C35AEF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_topic (id INT AUTO_INCREMENT NOT NULL, board_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3FFD3930D03D6C91 (board_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE board_post ADD CONSTRAINT FK_801C35AEF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE board_topic ADD CONSTRAINT FK_3FFD3930D03D6C91 FOREIGN KEY (board_category_id) REFERENCES board_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE board_post');
        $this->addSql('DROP TABLE board_topic');
    }
}
