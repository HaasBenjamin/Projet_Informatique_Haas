<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createOne();
    }

    public function getDependencies(): array
    {
        return [
            ContactFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
