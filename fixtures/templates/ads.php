<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'name' => $faker->catchPhrase,
    'imageSrc' => $faker->randomElement([
        '/img/item01.jpg',
        '/img/item02.jpg',
        '/img/item03.jpg',
        '/img/item04.jpg',
        '/img/item05.jpg',
        '/img/item06.jpg',
        '/img/item07.jpg',
        '/img/item08.jpg',
        '/img/item09.jpg',
        '/img/item10.jpg',
        '/img/item11.jpg',
        '/img/item12.jpg',
        '/img/item13.jpg',
        '/img/item14.jpg',
        '/img/item15.jpg',
        '/img/item16.jpg',
    ]),
    'typeId' => $faker->numberBetween(1, 2),
    'description' => $faker->realTextBetween(50, 1000),
    'author' => $faker->numberBetween(1, 10),
    'email' => $faker->email,
    'price' => $faker->numberBetween(100, 100000),
];
