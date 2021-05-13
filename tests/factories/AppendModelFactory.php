<?php

use Faker\Generator as Faker;
use mPhpMaster\BuilderFilter\Tests\TestClasses\Models\AppendModel;

$factory->define(AppendModel::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
    ];
});
