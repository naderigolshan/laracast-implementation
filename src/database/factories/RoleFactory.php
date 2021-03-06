<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\Spatie\Permission\Models\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
