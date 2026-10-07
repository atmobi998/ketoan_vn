<?php
/**
 * Schema file for CrudJsonApi tests
 *
 * This file defines the database schema for the test fixtures.
 * It is used by the SchemaLoader to create the test database.
 */
return [
    'countries' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'code' => ['type' => 'string', 'length' => 2, 'null' => false],
            'name' => ['type' => 'string', 'length' => 255, 'null' => false],
            'dummy_counter' => ['type' => 'integer'],
            'currency_id' => ['type' => 'integer', 'null' => true],
            'national_capital_id' => ['type' => 'integer', 'null' => true],
            'supercountry_id' => ['type' => 'integer', 'null' => true],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
    'countries_languages' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'country_id' => ['type' => 'integer', 'length' => 3, 'null' => false],
            'language_id' => ['type' => 'integer', 'length' => 100, 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
    'cultures' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'code' => ['type' => 'string', 'length' => 5, 'null' => false],
            'name' => ['type' => 'string', 'length' => 100, 'null' => false],
            'another_dummy_counter' => ['type' => 'integer'],
            'country_id' => ['type' => 'integer', 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
    'currencies' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'code' => ['type' => 'string', 'length' => 3, 'null' => false],
            'name' => ['type' => 'string', 'length' => 100, 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
    'languages' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'code' => ['type' => 'string', 'length' => 2, 'null' => false],
            'name' => ['type' => 'string', 'length' => 100, 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
    'national_capitals' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'name' => ['type' => 'string', 'length' => 100, 'null' => false],
            'description' => ['type' => 'string', 'length' => 255, 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
    'national_cities' => [
        'columns' => [
            'id' => ['type' => 'integer'],
            'name' => ['type' => 'string', 'length' => 100, 'null' => false],
            'country_id' => ['type' => 'integer', 'null' => false],
        ],
        'constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']],
        ],
    ],
];
