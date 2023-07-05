<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230705070729.php
final class Version20230705070729 extends AbstractMigration
========
final class Version20230704162452 extends AbstractMigration
>>>>>>>> 86fd55c0d0a24d0b0f6e5e58afbbab9edda6dd70:migrations/Version20230704162452.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230705070729.php
========
        $this->addSql('ALTER TABLE registration ADD PRIMARY KEY (activity_id, participant_id)');
>>>>>>>> 86fd55c0d0a24d0b0f6e5e58afbbab9edda6dd70:migrations/Version20230704162452.php
        $this->addSql('ALTER TABLE user_profile ADD picture_url VARCHAR(250) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profile DROP picture_url');
<<<<<<<< HEAD:migrations/Version20230705070729.php
========
        $this->addSql('DROP INDEX `primary` ON registration');
>>>>>>>> 86fd55c0d0a24d0b0f6e5e58afbbab9edda6dd70:migrations/Version20230704162452.php
    }
}
