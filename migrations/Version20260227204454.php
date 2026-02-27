<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260227204454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grid ADD total_solar_price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD total_grid_price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid DROP grid_power_day');
        $this->addSql('ALTER TABLE grid DROP invertor_power_day');
        $this->addSql('ALTER TABLE grid DROP grid_power_week');
        $this->addSql('ALTER TABLE grid DROP invertor_power_weel');
        $this->addSql('ALTER TABLE grid DROP grid_power_month');
        $this->addSql('ALTER TABLE grid DROP solal_price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grid ADD grid_power_day DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD invertor_power_day DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD grid_power_week DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD invertor_power_weel DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD grid_power_month DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE grid ADD solal_price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE grid DROP total_solar_price');
        $this->addSql('ALTER TABLE grid DROP total_grid_price');
    }
}
