<?php


namespace App\Tests\Api\AnimalFamily;

use App\Factory\AnimalCategoryFactory;
use App\Factory\AnimalFamilyFactory;
use App\Factory\SpeciesFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class AnimalFamilyPatchCest
{
    protected static function expectedProperties(): array
    {
        return [
            '@context' => 'string',
            '@id' => 'string',
            '@type' => 'string',
            'id' => 'integer:>0',
            'name' => 'string',
            'description' => 'string',
            'species' => [
                [
                    '@id' => 'string',
                    '@type' => 'string',
                    'id' => 'integer:>0',
                    'name' => 'string',
                ],
            ],
            'category' => [
                '@id' => 'string',
                '@type' => 'string',
                'id' => 'integer:>0',
                'name' => 'string',
            ],
        ];
    }

    public function patchAnimalFamily(ApiTester $I): void
    {
        $category = AnimalCategoryFactory::createOne(['name' => 'Formule1'])->object();

        $animalFamily = AnimalFamilyFactory::createOne([
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
            'category' => $category,
        ])->object();

        $species = SpeciesFactory::createOne(['family' => $animalFamily])->object();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPatch('/api/animal_families/1', [
            'name' => 'Eugène',
            'description' => 'Sinistre',
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType($this->expectedProperties());

        $I->seeResponseContainsJson([
            'id' => $animalFamily->getId(),
            'name' => 'Eugène',
            'description' => 'Sinistre',
            'species' => [
                [
                    '@id' => '/api/species/'.$species->getId(),
                    '@type' => 'Species',
                    'id' => $species->getId(),
                    'name' => $species->getName(),
                ],
            ],
            'category' => [
                '@id' => '/api/animal_categories/'.$category->getId(),
                '@type' => 'AnimalCategory',
                'id' => $category->getId(),
                'name' => 'Formule1',
            ],
        ]);
    }
}
