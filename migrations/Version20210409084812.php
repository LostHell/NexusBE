<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409084812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD posts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD5E258C5 FOREIGN KEY (posts_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_9474526CD5E258C5 ON comment (posts_id)');
        $this->addSql('ALTER TABLE post ADD comments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D63379586 FOREIGN KEY (comments_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D63379586 ON post (comments_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD5E258C5');
        $this->addSql('DROP INDEX IDX_9474526CD5E258C5 ON comment');
        $this->addSql('ALTER TABLE comment DROP posts_id');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D63379586');
        $this->addSql('DROP INDEX IDX_5A8A6C8D63379586 ON post');
        $this->addSql('ALTER TABLE post DROP comments_id');
    }
}
