<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(SQLgreyGUI\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('joh316'),
        'enabled' => true,
        'remember_token' => str_random(10),
    ];
});

$factory->define(SQLgreyGUI\Models\Greylist::class, function (Faker\Generator $faker) {
    return [
        'sender_name' => $faker->userName,
        'sender_domain' => $faker->safeEmailDomain,
        'src' => $faker->localIpv4,
        'rcpt' => $faker->safeEmail,
        'first_seen' => $faker->dateTime,
    ];
});

$factory->define(SQLgreyGUI\Models\AwlEmail::class, function (Faker\Generator $faker) {
    return [
        'sender_name' => $faker->unique()->userName,
        'sender_domain' => $faker->safeEmailDomain,
        'src' => $faker->ipv4,
        'first_seen' => $faker->dateTime,
        'last_seen' => $faker->dateTime,
    ];
});

$factory->define(SQLgreyGUI\Models\AwlDomain::class, function (Faker\Generator $faker) {
    return [
        'sender_domain' => $faker->safeEmailDomain,
        'src' => $faker->ipv4,
        'first_seen' => $faker->dateTime,
        'last_seen' => $faker->dateTime,
    ];
});

$factory->define(SQLgreyGUI\Models\OptOutEmail::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->userName.'@'.$faker->safeEmailDomain,
    ];
});

$factory->define(SQLgreyGUI\Models\OptOutDomain::class, function (Faker\Generator $faker) {
    return [
        'domain' => $faker->domainWord.$faker->unique()->randomNumber.$faker->safeEmailDomain,
    ];
});

$factory->define(SQLgreyGUI\Models\OptInEmail::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->userName.'@'.$faker->safeEmailDomain,
    ];
});

$factory->define(SQLgreyGUI\Models\OptInDomain::class, function (Faker\Generator $faker) {
    return [
        'domain' => $faker->domainWord.$faker->unique()->randomNumber.$faker->safeEmailDomain,
    ];
});
