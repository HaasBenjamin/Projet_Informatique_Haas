<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne(['lastname' => 'Chaunce', 'firstname' => 'Frédérique', 'email' => 'root@example.com', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['lastname' => 'Diandre', 'firstname' => 'Peter', 'email' => 'user@example.com', 'roles' => ['ROLE_USER']]);
        UserFactory::createMany(10);


        $manager->flush();
    }
}
