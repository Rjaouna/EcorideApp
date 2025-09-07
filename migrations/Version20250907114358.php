<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250907114358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE couvoiturage (id INT AUTO_INCREMENT NOT NULL, driver_id INT NOT NULL, depart_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', lieu_depart VARCHAR(50) NOT NULL, arrivee_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', lieu_arrivee VARCHAR(50) NOT NULL, statut VARCHAR(50) NOT NULL, nb_place INT NOT NULL, prix_personne DOUBLE PRECISION NOT NULL, INDEX IDX_5DCFD414C3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couvoiturage_user (couvoiturage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_79064BBA93E111FB (couvoiturage_id), INDEX IDX_79064BBAA76ED395 (user_id), PRIMARY KEY(couvoiturage_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE couvoiturage ADD CONSTRAINT FK_5DCFD414C3423909 FOREIGN KEY (driver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE couvoiturage_user ADD CONSTRAINT FK_79064BBA93E111FB FOREIGN KEY (couvoiturage_id) REFERENCES couvoiturage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE couvoiturage_user ADD CONSTRAINT FK_79064BBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE naissance_at naissance_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couvoiturage DROP FOREIGN KEY FK_5DCFD414C3423909');
        $this->addSql('ALTER TABLE couvoiturage_user DROP FOREIGN KEY FK_79064BBA93E111FB');
        $this->addSql('ALTER TABLE couvoiturage_user DROP FOREIGN KEY FK_79064BBAA76ED395');
        $this->addSql('DROP TABLE couvoiturage');
        $this->addSql('DROP TABLE couvoiturage_user');
        $this->addSql('ALTER TABLE user CHANGE naissance_at naissance_at DATE NOT NULL');
    }
}
