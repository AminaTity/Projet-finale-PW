<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112160224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educateur (id INT AUTO_INCREMENT NOT NULL, licencie_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_763C0122E7927C74 (email), UNIQUE INDEX UNIQ_763C0122B56DCD74 (licencie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licencie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, contact_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, INDEX IDX_3B755612BCF5E72D (categorie_id), INDEX IDX_3B755612E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_contact (id INT AUTO_INCREMENT NOT NULL, educateur_id INT NOT NULL, date_envoi DATETIME NOT NULL, objet VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_96DF67576BFC1A0E (educateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_contact_categorie (mail_contact_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_340E21C33362CFB6 (mail_contact_id), INDEX IDX_340E21C3BCF5E72D (categorie_id), PRIMARY KEY(mail_contact_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_contact_contact (mail_contact_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_94F6F3BB3362CFB6 (mail_contact_id), INDEX IDX_94F6F3BBE7A1254A (contact_id), PRIMARY KEY(mail_contact_id, contact_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_edu (id INT AUTO_INCREMENT NOT NULL, educateur_id INT NOT NULL, date_envoi DATETIME NOT NULL, objet VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_8CB8D4A36BFC1A0E (educateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_edu_educateur (mail_edu_id INT NOT NULL, educateur_id INT NOT NULL, INDEX IDX_7A814C4C9D911D20 (mail_edu_id), INDEX IDX_7A814C4C6BFC1A0E (educateur_id), PRIMARY KEY(mail_edu_id, educateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE educateur ADD CONSTRAINT FK_763C0122B56DCD74 FOREIGN KEY (licencie_id) REFERENCES licencie (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE mail_contact ADD CONSTRAINT FK_96DF67576BFC1A0E FOREIGN KEY (educateur_id) REFERENCES educateur (id)');
        $this->addSql('ALTER TABLE mail_contact_categorie ADD CONSTRAINT FK_340E21C33362CFB6 FOREIGN KEY (mail_contact_id) REFERENCES mail_contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_contact_categorie ADD CONSTRAINT FK_340E21C3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_contact_contact ADD CONSTRAINT FK_94F6F3BB3362CFB6 FOREIGN KEY (mail_contact_id) REFERENCES mail_contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_contact_contact ADD CONSTRAINT FK_94F6F3BBE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_edu ADD CONSTRAINT FK_8CB8D4A36BFC1A0E FOREIGN KEY (educateur_id) REFERENCES educateur (id)');
        $this->addSql('ALTER TABLE mail_edu_educateur ADD CONSTRAINT FK_7A814C4C9D911D20 FOREIGN KEY (mail_edu_id) REFERENCES mail_edu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_edu_educateur ADD CONSTRAINT FK_7A814C4C6BFC1A0E FOREIGN KEY (educateur_id) REFERENCES educateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur DROP FOREIGN KEY FK_763C0122B56DCD74');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612BCF5E72D');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612E7A1254A');
        $this->addSql('ALTER TABLE mail_contact DROP FOREIGN KEY FK_96DF67576BFC1A0E');
        $this->addSql('ALTER TABLE mail_contact_categorie DROP FOREIGN KEY FK_340E21C33362CFB6');
        $this->addSql('ALTER TABLE mail_contact_categorie DROP FOREIGN KEY FK_340E21C3BCF5E72D');
        $this->addSql('ALTER TABLE mail_contact_contact DROP FOREIGN KEY FK_94F6F3BB3362CFB6');
        $this->addSql('ALTER TABLE mail_contact_contact DROP FOREIGN KEY FK_94F6F3BBE7A1254A');
        $this->addSql('ALTER TABLE mail_edu DROP FOREIGN KEY FK_8CB8D4A36BFC1A0E');
        $this->addSql('ALTER TABLE mail_edu_educateur DROP FOREIGN KEY FK_7A814C4C9D911D20');
        $this->addSql('ALTER TABLE mail_edu_educateur DROP FOREIGN KEY FK_7A814C4C6BFC1A0E');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE educateur');
        $this->addSql('DROP TABLE licencie');
        $this->addSql('DROP TABLE mail_contact');
        $this->addSql('DROP TABLE mail_contact_categorie');
        $this->addSql('DROP TABLE mail_contact_contact');
        $this->addSql('DROP TABLE mail_edu');
        $this->addSql('DROP TABLE mail_edu_educateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
