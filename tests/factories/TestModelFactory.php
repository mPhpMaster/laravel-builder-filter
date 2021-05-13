<?php

use Faker\Generator as Faker;
use mPhpMaster\BuilderFilter\Tests\TestClasses\Models\TestModel;

$factory->define(TestModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
