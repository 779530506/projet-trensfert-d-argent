<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207221300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, montant_debut DATE NOT NULL, montant_fin DATE NOT NULL, frais DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode_user (periode_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_44FF0AFCF384C1CF (periode_id), INDEX IDX_44FF0AFCA76ED395 (user_id), PRIMARY KEY(periode_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periode_compte (periode_id INT NOT NULL, compte_id INT NOT NULL, INDEX IDX_D9215F0EF384C1CF (periode_id), INDEX IDX_D9215F0EF2C56620 (compte_id), PRIMARY KEY(periode_id, compte_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_trensfert_id INT NOT NULL, user_retrait_id INT DEFAULT NULL, compte_id INT NOT NULL, date_trensfert DATE NOT NULL, date_retrait DATE DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, status TINYINT(1) NOT NULL, code INT NOT NULL, frais DOUBLE PRECISION NOT NULL, nom_expediteur VARCHAR(25) NOT NULL, prenom_expediteur VARCHAR(25) NOT NULL, tel_expediteur VARCHAR(25) NOT NULL, cni_expediteur VARCHAR(25) NOT NULL, nom_beneficiaire VARCHAR(25) NOT NULL, prenom_beneficiaire VARCHAR(25) NOT NULL, tel_beneficiaire VARCHAR(25) NOT NULL, cni_beneficiaire VARCHAR(25) DEFAULT NULL, INDEX IDX_723705D1B5BB97D5 (user_trensfert_id), INDEX IDX_723705D1D99F8396 (user_retrait_id), INDEX IDX_723705D1F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, ninea VARCHAR(10) NOT NULL, registre_du_commerce VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, user_createur_id INT NOT NULL, partenaire_id INT NOT NULL, numero_compte VARCHAR(9) NOT NULL, solde DOUBLE PRECISION NOT NULL, created_date DATE NOT NULL, INDEX IDX_CFF65260DAB9C870 (user_createur_id), INDEX IDX_CFF6526098DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, partenaire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephon VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, date_naissance DATE NOT NULL, is_active TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), INDEX IDX_8D93D64998DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, user_depot_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_depot DATE NOT NULL, INDEX IDX_47948BBCF2C56620 (compte_id), INDEX IDX_47948BBC659D30DE (user_depot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE periode_user ADD CONSTRAINT FK_44FF0AFCF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periode_user ADD CONSTRAINT FK_44FF0AFCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periode_compte ADD CONSTRAINT FK_D9215F0EF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periode_compte ADD CONSTRAINT FK_D9215F0EF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1B5BB97D5 FOREIGN KEY (user_trensfert_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260DAB9C870 FOREIGN KEY (user_createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE periode_user DROP FOREIGN KEY FK_44FF0AFCF384C1CF');
        $this->addSql('ALTER TABLE periode_compte DROP FOREIGN KEY FK_D9215F0EF384C1CF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526098DE13AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998DE13AC');
        $this->addSql('ALTER TABLE periode_compte DROP FOREIGN KEY FK_D9215F0EF2C56620');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF2C56620');
        $this->addSql('ALTER TABLE periode_user DROP FOREIGN KEY FK_44FF0AFCA76ED395');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1B5BB97D5');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D99F8396');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260DAB9C870');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC659D30DE');
        $this->addSql('DROP TABLE tarif');
        $this->addSql('DROP TABLE periode');
        $this->addSql('DROP TABLE periode_user');
        $this->addSql('DROP TABLE periode_compte');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE depot');
    }
}