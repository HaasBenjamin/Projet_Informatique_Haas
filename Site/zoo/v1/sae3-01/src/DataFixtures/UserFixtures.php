<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(20, function () {
            $bool = UserFactory::faker()->boolean(15);

            return [
                'hiringDate' => $bool ? UserFactory::faker()->datetime() : null,
                'contractDuration' => $bool ? UserFactory::faker()->numberBetween(1, 365) : null,
                'roles' => $bool ? ['ROLE_EMPLOYEE'] : ['ROLE_USER'],
            ];
        });

        UserFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
            'firstName' => 'Pierre',
            'lastName' => 'Gouedar',
            'roles' => ['ROLE_ADMIN'],
        ]);
    }
}
