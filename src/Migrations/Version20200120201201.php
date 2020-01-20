<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200120201201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephon VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, date_naissance DATE NOT NULL, is_active TINYINT(1) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT NOT NULL, ninea VARCHAR(10) NOT NULL, registre_du_commerce VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT NOT NULL, user_createur_id INT NOT NULL, numero_compte VARCHAR(9) NOT NULL, solde DOUBLE PRECISION NOT NULL, created_date DATE NOT NULL, INDEX IDX_CFF6526098DE13AC (partenaire_id), INDEX IDX_CFF65260DAB9C870 (user_createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, user_depot_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_depot DATE NOT NULL, INDEX IDX_47948BBCF2C56620 (compte_id), INDEX IDX_47948BBC659D30DE (user_depot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF65260DAB9C870 FOREIGN KEY (user_createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373BF396750');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF65260DAB9C870');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC659D30DE');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526098DE13AC');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF2C56620');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE depot');
    }
}
