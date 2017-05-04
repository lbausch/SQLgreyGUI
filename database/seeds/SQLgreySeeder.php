<?php

use Illuminate\Database\Seeder;

class SQLgreySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \SQLgreyGUI\Models\Greylist::truncate();
        \SQLgreyGUI\Models\AwlEmail::truncate();
        \SQLgreyGUI\Models\AwlDomain::truncate();
        \SQLgreyGUI\Models\OptOutEmail::truncate();
        \SQLgreyGUI\Models\OptOutDomain::truncate();
        \SQLgreyGUI\Models\OptInEmail::truncate();
        \SQLgreyGUI\Models\OptInDomain::truncate();

        $this->call(GreylistTableSeeder::class);
        $this->call(AwlEmailTableSeeder::class);
        $this->call(AwlDomainTableSeeder::class);
        $this->call(OptOutEmailTableSeeder::class);
        $this->call(OptOutDomainTableSeeder::class);
        $this->call(OptInEmailTableSeeder::class);
        $this->call(OptInDomainTableSeeder::class);
    }
}
