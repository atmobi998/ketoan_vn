<?php
namespace CrudJsonApi\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class CountriesFixture extends TestFixture
{
    public array $records = [
        ['code' => 'NL', 'name' => 'The Netherlands', 'dummy_counter' => 11111, 'currency_id' => 1, 'national_capital_id' => 1],
        ['code' => 'BG', 'name' => 'Bulgaria', 'dummy_counter' => 22222, 'currency_id' => 1, 'national_capital_id' => 2],
        ['code' => 'IT', 'name' => 'Italy', 'dummy_counter' => 33333, 'currency_id' => 1, 'national_capital_id' => 4],
        ['code' => 'VT', 'name' => 'Vatican', 'dummy_counter' => 44444, 'currency_id' => 1, 'national_capital_id' => 5, 'supercountry_id' => 3],
        ['code' => 'US', 'name' => 'United States of America', 'dummy_counter' => 33333, 'currency_id' => 2, 'national_capital_id' => 6],
    ];
}
