<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250909090656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wallet_couvoiturage (wallet_id INT NOT NULL, couvoiturage_id INT NOT NULL, INDEX IDX_1265CBBA712520F3 (wallet_id), INDEX IDX_1265CBBA93E111FB (couvoiturage_id), PRIMARY KEY(wallet_id, couvoiturage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wallet_couvoiturage ADD CONSTRAINT FK_1265CBBA712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wallet_couvoiturage ADD CONSTRAINT FK_1265CBBA93E111FB FOREIGN KEY (couvoiturage_id) REFERENCES couvoiturage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet_couvoiturage DROP FOREIGN KEY FK_1265CBBA712520F3');
        $this->addSql('ALTER TABLE wallet_couvoiturage DROP FOREIGN KEY FK_1265CBBA93E111FB');
        $this->addSql('DROP TABLE wallet_couvoiturage');
    }
}
