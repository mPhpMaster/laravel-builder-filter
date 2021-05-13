<?php

use Faker\Generator as Faker;
use mPhpMaster\BuilderFilter\Tests\TestClasses\Models\SoftDeleteModel;

$factory->define(SoftDeleteModel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
