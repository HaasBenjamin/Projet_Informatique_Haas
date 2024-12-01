<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents(__DIR__.'/data/Category.json');
        $data = json_decode($json, true);
        CategoryFactory::createSequence($data);
    }

}
