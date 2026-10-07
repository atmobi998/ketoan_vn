<?php
namespace CrudJsonApi\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CountriesLanguagesFixture extends TestFixture
{
    public array $records = [
        ['country_id' => 1, 'language_id' => 1],
        ['country_id' => 1, 'language_id' => 2],
        ['country_id' => 2, 'language_id' => 4],
        ['country_id' => 3, 'language_id' => 3],
        ['country_id' => 4, 'language_id' => 4],
        ['country_id' => 5, 'language_id' => 1],
    ];
}
