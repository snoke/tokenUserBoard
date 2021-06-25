<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624094101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_category ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE board_category ADD CONSTRAINT FK_96BB1A78F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_96BB1A78F675F31B ON board_category (author_id)');
        $this->addSql('ALTER TABLE board_topic ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE board_topic ADD CONSTRAINT FK_3FFD3930F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3FFD3930F675F31B ON board_topic (author_id)');
        $this->addSql('ALTER TABLE user ADD api VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_category DROP FOREIGN KEY FK_96BB1A78F675F31B');
        $this->addSql('DROP INDEX IDX_96BB1A78F675F31B ON board_category');
        $this->addSql('ALTER TABLE board_category DROP author_id');
        $this->addSql('ALTER TABLE board_topic DROP FOREIGN KEY FK_3FFD3930F675F31B');
        $this->addSql('DROP INDEX IDX_3FFD3930F675F31B ON board_topic');
        $this->addSql('ALTER TABLE board_topic DROP author_id');
        $this->addSql('ALTER TABLE user DROP api');
    }
}
