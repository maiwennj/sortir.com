<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230705114127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE activity_name activity_name VARCHAR(30) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE picture_url picture_url VARCHAR(250) DEFAULT NULL, CHANGE cancellation_reason cancellation_reason LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE city CHANGE city_name city_name VARCHAR(30) NOT NULL, CHANGE post_code post_code VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE location CHANGE location_name location_name VARCHAR(30) NOT NULL, CHANGE street street VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE site CHANGE site_name site_name VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB8BAC62AF');
        $this->addSql('ALTER TABLE location CHANGE location_name location_name VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE street street VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE site CHANGE site_name site_name VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A64D218E');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A5D83CC1');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AF6BD1646');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA0631C12');
        $this->addSql('ALTER TABLE activity CHANGE activity_name activity_name VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE picture_url picture_url VARCHAR(250) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cancellation_reason cancellation_reason LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE city CHANGE city_name city_name VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE post_code post_code VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A781C06096');
        $this->addSql('ALTER TABLE registration DROP FOREIGN KEY FK_62A8A7A79D1C3019');
    }
}
