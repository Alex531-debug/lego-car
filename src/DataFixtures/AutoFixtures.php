<?php

namespace App\DataFixtures;

use App\Factory\AutoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AutoFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        AutoFactory::new()->createMany(20);
    }

    public function getOrder()
    {
        return 2;
    }
}
