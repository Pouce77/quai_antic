<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417073133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD morning_start_at TIME NOT NULL, ADD morning_end_at TIME NOT NULL, ADD afternoon_start_at TIME NOT NULL, ADD afternoon_end_at TIME NOT NULL, DROP start_at, DROP end_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horaire ADD start_at TIME NOT NULL, ADD end_at TIME NOT NULL, DROP morning_start_at, DROP morning_end_at, DROP afternoon_start_at, DROP afternoon_end_at');
    }
}
