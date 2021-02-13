<?php

namespace App\DataFixtures;

use App\Factory\BrandFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        BrandFactory::new()->createMany(20);
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
