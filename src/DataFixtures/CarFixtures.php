<?php

namespace App\DataFixtures;

use App\Factory\CarFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        CarFactory::new()->createMany(100);
    }

    public function getOrder()
    {
        return 2;
    }
}
