<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Books;
use Faker\Generator as Faker;

$factory->define(Books::class, function (Faker $faker) {
    $authors = App\Author::pluck('id')->toArray();
    return [
        'author_id'=>  function() {return \App\Author::all()->random();},
        'name' =>  $faker->sentence,
        'release_date' =>  $faker->date('y-m-d')
    ];
});
