<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220919140551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles_users DROP FOREIGN KEY FK_FC618D1D67B3B43D');
        $this->addSql('ALTER TABLE articles_users DROP FOREIGN KEY FK_FC618D1D1EBAF6CC');
        $this->addSql('DROP TABLE articles_users');
        $this->addSql('ALTER TABLE articles ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316879F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_BFDD316879F37AE5 ON articles (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_users (articles_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_FC618D1D1EBAF6CC (articles_id), INDEX IDX_FC618D1D67B3B43D (users_id), PRIMARY KEY(articles_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE articles_users ADD CONSTRAINT FK_FC618D1D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_users ADD CONSTRAINT FK_FC618D1D1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316879F37AE5');
        $this->addSql('DROP INDEX IDX_BFDD316879F37AE5 ON articles');
        $this->addSql('ALTER TABLE articles DROP id_user_id');
    }
}
