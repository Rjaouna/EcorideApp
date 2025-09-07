<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250906222437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE preference_utilisateur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, politique_tabac VARCHAR(50) DEFAULT NULL, politique_animaux VARCHAR(50) DEFAULT NULL, niveau_conversation VARCHAR(50) DEFAULT NULL, niveau_musique VARCHAR(50) DEFAULT NULL, autorise_nourriture VARCHAR(50) DEFAULT NULL, autorise_boissons VARCHAR(50) DEFAULT NULL, taille_max_bagages INT DEFAULT NULL, UNIQUE INDEX UNIQ_F920AEA9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE preference_utilisateur ADD CONSTRAINT FK_F920AEA9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE preference_utilisateur DROP FOREIGN KEY FK_F920AEA9A76ED395');
        $this->addSql('DROP TABLE preference_utilisateur');
    }
}
