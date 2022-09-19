<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919150950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316879F37AE5');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31687B255871');
        $this->addSql('DROP INDEX IDX_BFDD31687B255871 ON articles');
        $this->addSql('DROP INDEX IDX_BFDD316879F37AE5 ON articles');
        $this->addSql('ALTER TABLE articles DROP id_comments_id, CHANGE id_user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168A76ED395 ON articles (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168A76ED395');
        $this->addSql('DROP INDEX IDX_BFDD3168A76ED395 ON articles');
        $this->addSql('ALTER TABLE articles ADD id_comments_id INT DEFAULT NULL, CHANGE user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316879F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31687B255871 FOREIGN KEY (id_comments_id) REFERENCES comments (id)');
        $this->addSql('CREATE INDEX IDX_BFDD31687B255871 ON articles (id_comments_id)');
        $this->addSql('CREATE INDEX IDX_BFDD316879F37AE5 ON articles (id_user_id)');
    }
}
