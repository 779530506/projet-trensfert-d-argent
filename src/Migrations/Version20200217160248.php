<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200217160248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE periode_compte DROP FOREIGN KEY FK_D9215F0EF384C1CF');
        $this->addSql('ALTER TABLE periode_user DROP FOREIGN KEY FK_44FF0AFCF384C1CF');
        $this->addSql('CREATE TABLE affecter (id INT AUTO_INCREMENT NOT NULL, compte_affecter_id INT NOT NULL, user_affecter_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_C290057A9E4EC521 (compte_affecter_id), INDEX IDX_C290057A1B4486E0 (user_affecter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A9E4EC521 FOREIGN KEY (compte_affecter_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE affecter ADD CONSTRAINT FK_C290057A1B4486E0 FOREIGN KEY (user_affecter_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE periode');
        $this->addSql('DROP TABLE periode_compte');
        $this->addSql('DROP TABLE periode_user');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F2C56620');
        $this->addSql('DROP INDEX IDX_723705D1F2C56620 ON transaction');
        $this->addSql('ALTER TABLE transaction CHANGE compte_id compte_trensfert_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1595D6FB0 FOREIGN KEY (compte_trensfert_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D1595D6FB0 ON transaction (compte_trensfert_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE periode (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE periode_compte (periode_id INT NOT NULL, compte_id INT NOT NULL, INDEX IDX_D9215F0EF384C1CF (periode_id), INDEX IDX_D9215F0EF2C56620 (compte_id), PRIMARY KEY(periode_id, compte_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE periode_user (periode_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_44FF0AFCF384C1CF (periode_id), INDEX IDX_44FF0AFCA76ED395 (user_id), PRIMARY KEY(periode_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE periode_compte ADD CONSTRAINT FK_D9215F0EF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periode_compte ADD CONSTRAINT FK_D9215F0EF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periode_user ADD CONSTRAINT FK_44FF0AFCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periode_user ADD CONSTRAINT FK_44FF0AFCF384C1CF FOREIGN KEY (periode_id) REFERENCES periode (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE affecter');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1595D6FB0');
        $this->addSql('DROP INDEX IDX_723705D1595D6FB0 ON transaction');
        $this->addSql('ALTER TABLE transaction CHANGE compte_trensfert_id compte_id INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_723705D1F2C56620 ON transaction (compte_id)');
    }
}
