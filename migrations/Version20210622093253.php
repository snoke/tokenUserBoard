<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622093253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_post ADD board_topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE board_post ADD CONSTRAINT FK_801C35AE8FA22384 FOREIGN KEY (board_topic_id) REFERENCES board_topic (id)');
        $this->addSql('CREATE INDEX IDX_801C35AE8FA22384 ON board_post (board_topic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_post DROP FOREIGN KEY FK_801C35AE8FA22384');
        $this->addSql('DROP INDEX IDX_801C35AE8FA22384 ON board_post');
        $this->addSql('ALTER TABLE board_post DROP board_topic_id');
    }
}
