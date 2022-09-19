<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919130632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles ADD id_comments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31687B255871 FOREIGN KEY (id_comments_id) REFERENCES comments (id)');
        $this->addSql('CREATE INDEX IDX_BFDD31687B255871 ON articles (id_comments_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31687B255871');
        $this->addSql('DROP INDEX IDX_BFDD31687B255871 ON articles');
        $this->addSql('ALTER TABLE articles DROP id_comments_id');
    }
}
