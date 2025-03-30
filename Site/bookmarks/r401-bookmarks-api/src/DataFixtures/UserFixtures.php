<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['login' => 'user001', 'lastname' => 'lastname1', 'firstname' => 'firstname1', 'email' => 'user1@example.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['login' => 'user002', 'lastname' => 'lastname2', 'firstname' => 'firstname2', 'email' => 'user2@example.com', 'roles' => ['ROLE_USER']]);
        UserFactory::createOne(['login' => 'user003', 'lastname' => 'lastname3', 'firstname' => 'firstname3', 'email' => 'user3@example.com', 'roles' => ['ROLE_USER']]);
        UserFactory::createMany(20);
    }
}
