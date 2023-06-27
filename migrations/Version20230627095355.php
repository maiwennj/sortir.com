<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627095355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity ADD location_id INT NOT NULL, ADD state_id INT NOT NULL, ADD site_id INT NOT NULL, ADD organiser_id INT NOT NULL, DROP state, CHANGE name activity_name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A5D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AA0631C12 FOREIGN KEY (organiser_id) REFERENCES user_profile (id)');
        $this->addSql('CREATE INDEX IDX_AC74095A64D218E ON activity (location_id)');
        $this->addSql('CREATE INDEX IDX_AC74095A5D83CC1 ON activity (state_id)');
        $this->addSql('CREATE INDEX IDX_AC74095AF6BD1646 ON activity (site_id)');
        $this->addSql('CREATE INDEX IDX_AC74095AA0631C12 ON activity (organiser_id)');
        $this->addSql('ALTER TABLE city CHANGE name_city city_name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE location ADD city_id INT NOT NULL, CHANGE name_location location_name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB8BAC62AF ON location (city_id)');
        $this->addSql('ALTER TABLE site CHANGE name_site site_name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496B9DD454');
        $this->addSql('DROP INDEX UNIQ_8D93D6496B9DD454 ON user');
        $this->addSql('ALTER TABLE user CHANGE user_profile_id profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES user_profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
        $this->addSql('ALTER TABLE user_profile ADD site_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_D95AB405F6BD1646 ON user_profile (site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site CHANGE site_name name_site VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A64D218E');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A5D83CC1');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AF6BD1646');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AA0631C12');
        $this->addSql('DROP INDEX IDX_AC74095A64D218E ON activity');
        $this->addSql('DROP INDEX IDX_AC74095A5D83CC1 ON activity');
        $this->addSql('DROP INDEX IDX_AC74095AF6BD1646 ON activity');
        $this->addSql('DROP INDEX IDX_AC74095AA0631C12 ON activity');
        $this->addSql('ALTER TABLE activity ADD state INT DEFAULT NULL, DROP location_id, DROP state_id, DROP site_id, DROP organiser_id, CHANGE activity_name name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB405F6BD1646');
        $this->addSql('DROP INDEX IDX_D95AB405F6BD1646 ON user_profile');
        $this->addSql('ALTER TABLE user_profile DROP site_id');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB8BAC62AF');
        $this->addSql('DROP INDEX IDX_5E9E89CB8BAC62AF ON location');
        $this->addSql('ALTER TABLE location DROP city_id, CHANGE location_name name_location VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON `user`');
        $this->addSql('ALTER TABLE `user` CHANGE profile_id user_profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6496B9DD454 FOREIGN KEY (user_profile_id) REFERENCES user_profile (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B9DD454 ON `user` (user_profile_id)');
        $this->addSql('ALTER TABLE city CHANGE city_name name_city VARCHAR(30) NOT NULL');
    }
}
