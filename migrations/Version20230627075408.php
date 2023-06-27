<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627075408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, participant_id INT NOT NULL, registration_date DATETIME NOT NULL, INDEX IDX_62A8A7A781C06096 (activity_id), INDEX IDX_62A8A7A79D1C3019 (participant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A79D1C3019 FOREIGN KEY (participant_id) REFERENCES user_profile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A781C06096');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A79D1C3019');
        $this->addSql('DROP TABLE registration');
    }
}
