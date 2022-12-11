<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'author' => $faker->numberBetween(1, 10),
    'adId' => $faker->numberBetween(1, 50),
    'text' => $faker->realTextBetween(20, 500),
];
