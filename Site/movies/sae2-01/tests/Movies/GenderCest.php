<?php

namespace Tests\Movies;

use Entity\Gender;
use Tests\MoviesTester;

class GenderCest
{
    public function findById(MoviesTester $I): void
    {
        $expectedMovies = [
            ['id' => 12, 'name'=>'Aventure']
                ];

        $genders = [Gender::findById(12)];
        $I->assertCount(count($expectedMovies), $genders);
        $I->assertContainsOnlyInstancesOf(Gender::class, $genders);
        foreach ($genders as $index => $gender) {
            $expectedMovie = $expectedMovies[$index];
            $I->assertEquals($expectedMovie['id'], $gender->getId());
            $I->assertEquals($expectedMovie['name'], $gender->getName());
        }
    }

}
