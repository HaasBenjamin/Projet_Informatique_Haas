<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Factory\AddressFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents(__DIR__.'/data/address.json');
        $file = json_decode($json, true);
        $users = UserFactory::all();
        $file[0]['user'] = $users[0];
        $file[1]['user'] = $users[0];
        $file[2]['user'] = $users[1];
        $file[3]['user'] = $users[1];
        AddressFactory::createSequence($file);
        AddressFactory::createMany(10);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
