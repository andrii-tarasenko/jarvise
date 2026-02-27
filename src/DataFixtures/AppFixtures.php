<?php

namespace App\DataFixtures;

use App\Entity\Grid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $grid = new Grid();

            // Random realistic solar and grid data
            $solarPower = mt_rand(0, 5000); // 0 to 5kW
            $gridPower = mt_rand(-2000, 3000); // negative means exporting

            // Random daily yields
            $solarDaily = mt_rand(5, 30) + (mt_rand(0, 99) / 100);

            $grid->setSolarPower($solarPower);
            $grid->setGridPower($gridPower);
            $grid->setPrice(0.00);

            $manager->persist($grid);
        }

        $manager->flush();
    }
}
