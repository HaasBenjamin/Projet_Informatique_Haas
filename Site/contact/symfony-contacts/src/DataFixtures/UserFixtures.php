<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['lastname' => 'Stark', 'firstname' => 'Tony', 'email' => 'root@example.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['lastname' => 'Parker', 'firstname' => 'Peter', 'email' => 'user@example.com', 'roles' => ['ROLE_USER']]);
        UserFactory::createMany(10);
    }
}
