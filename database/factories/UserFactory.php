<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'admin' => rand(0, 1)
    ];
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'category' => $faker->name,
        'color' => $faker->hexcolor,
        'font_color' => array_rand(['black', 'white'] , rand(0, 1))
    ];
});

$factory->define(Event::class, function (Faker $faker) {
	$hour = $faker->time('H', '21');
	$start_time = $hour . ':00';
	$end_time = ($hour + 1) . ':00';
	$days_of_week_array = [
		'["1","2","3","4","5","6","0"]',
		'["1","3","5","0"]'
	];
	$live = rand(0, 1);
	$minimum_age = rand(4, 14);
	$maximum_age = rand($minimum_age, 16);
    return [
		'title' => $faker->sentence(rand(3,8), true),
		'category_id' => rand(0,10),
		'description' => $faker->paragraph(rand(1,3), true),
		'live_web_link' => $live ? $faker->url : null,
		'start_time' => $start_time,
		'end_time' => $end_time,
		'days_of_week' => $days_of_week_array[rand(0, 1)],
		'requires_supervision' => rand(0, 1),
		'dfe_approved' => rand(0, 1),
		'web_link' => $faker->url,
		'minimum_age' => $minimum_age,
		'maximum_age' => $maximum_age,
		'live_youtube_link' => $live ? $faker->url : null,
		'live_facebook_link' => $live ? $faker->url : null,
		'live_instagram_link' => $live ? $faker->url : null,
		'youtube_link' => $faker->url,
		'facebook_link' => $faker->url,
		'instagram_link' => $faker->url,
    ];
});