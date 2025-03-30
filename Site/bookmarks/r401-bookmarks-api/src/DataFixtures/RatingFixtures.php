<?php

namespace App\DataFixtures;

use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RatingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = UserFactory::all();
        foreach ($users as $user) {
            foreach (BookmarkFactory::randomRange(3, 7) as $bookmark) {
                RatingFactory::createOne(['user' => $user, 'bookmark' => $bookmark, 'value' => rand(0, 10)]);
            }
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            BookmarkFixtures::class,
        ];
    }
}
