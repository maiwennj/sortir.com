<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704073911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD cancellation_reason LONGTEXT DEFAULT NULL');
        $this->addSql('DROP INDEX `primary` ON registration');
        $this->addSql('ALTER TABLE registration ADD PRIMARY KEY (activity_id, participant_id)');
        $this->addSql('ALTER TABLE user_profile ADD picture_url VARCHAR(250) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profile DROP picture_url');
        $this->addSql('ALTER TABLE activity DROP cancellation_reason');
        $this->addSql('DROP INDEX `PRIMARY` ON registration');
        $this->addSql('ALTER TABLE registration ADD PRIMARY KEY (registration_date, activity_id)');
    }
}
