<?php

$factory->define(SQLgreyGUI\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(SQLgreyGUI\Models\Greylist::class, function (Faker\Generator $faker) {
    return [
        'sender_name' => $faker->word,
        'sender_domain' => $faker->safeEmailDomain,
        'src' => $faker->ipv4,
        'rcpt' => $faker->safeEmail,
        'first_seen' => $faker->dateTime,
    ];
});

$factory->define(SQLgreyGUI\Models\AwlEmail::class, function (Faker\Generator $faker) {
    return [
        'sender_name' => $faker->word,
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
        'email' => $faker->safeEmail,
    ];
});

$factory->define(SQLgreyGUI\Models\OptOutDomain::class, function (Faker\Generator $faker) {
    return [
        'domain' => $faker->randomLetter.$faker->domainWord.$faker->safeEmailDomain,
    ];
});

$factory->define(SQLgreyGUI\Models\OptInEmail::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->safeEmail,
    ];
});

$factory->define(SQLgreyGUI\Models\OptInDomain::class, function (Faker\Generator $faker) {
    return [
        'domain' => $faker->randomLetter.$faker->domainWord.$faker->safeEmailDomain,
    ];
});

$factory->define(SQLgreyGUI\Models\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->userName,
        'email' => $faker->safeEmail,
        'enabled' => true,
        'password' => bcrypt('joh316'),
    ];
});
