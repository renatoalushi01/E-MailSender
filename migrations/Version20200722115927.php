<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722115927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE emails ADD usr_id_id INT DEFAULT NULL, CHANGE too too VARCHAR(100) DEFAULT NULL, CHANGE subject subject VARCHAR(150) DEFAULT NULL, CHANGE date date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE emails ADD CONSTRAINT FK_4C81E85241AB162D FOREIGN KEY (usr_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C81E85241AB162D ON emails (usr_id_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE emails DROP FOREIGN KEY FK_4C81E85241AB162D');
        $this->addSql('DROP INDEX IDX_4C81E85241AB162D ON emails');
        $this->addSql('ALTER TABLE emails DROP usr_id_id, CHANGE too too VARCHAR(100) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE subject subject VARCHAR(150) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE date date DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
