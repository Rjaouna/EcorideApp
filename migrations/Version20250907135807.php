<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250907135807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couvoiturage ADD voiture_id INT NOT NULL');
        $this->addSql('ALTER TABLE couvoiturage ADD CONSTRAINT FK_5DCFD414181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('CREATE INDEX IDX_5DCFD414181A8BA ON couvoiturage (voiture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE couvoiturage DROP FOREIGN KEY FK_5DCFD414181A8BA');
        $this->addSql('DROP INDEX IDX_5DCFD414181A8BA ON couvoiturage');
        $this->addSql('ALTER TABLE couvoiturage DROP voiture_id');
    }
}
