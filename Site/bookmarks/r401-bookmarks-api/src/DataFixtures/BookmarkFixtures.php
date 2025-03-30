<?php

namespace App\DataFixtures;

use App\Factory\BookmarkFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookmarkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents(__DIR__.'/data/bookmarks.json');
        $data = json_decode($json, true);
        BookmarkFactory::createSequence($data);
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
