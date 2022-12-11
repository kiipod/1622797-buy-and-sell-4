<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'name' => $faker->firstName,
    'lastName' => $faker->lastName,
    'email' => $faker->email,
    'password' => $faker->password,
    'avatarSrc' => $faker->randomElement([
        '/img/avatar01.jpg',
        '/img/avatar02.jpg',
        '/img/avatar03.jpg',
        '/img/avatar04.jpg',
    ])
];
