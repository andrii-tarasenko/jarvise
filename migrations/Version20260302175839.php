<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260302175839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grid ADD voltage DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD current DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD energy DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD frequency DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD power_f DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grid DROP voltage');
        $this->addSql('ALTER TABLE grid DROP current');
        $this->addSql('ALTER TABLE grid DROP energy');
        $this->addSql('ALTER TABLE grid DROP frequency');
        $this->addSql('ALTER TABLE grid DROP power_f');
    }
}
