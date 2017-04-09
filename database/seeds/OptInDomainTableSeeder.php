<?php

use Illuminate\Database\Seeder;

class OptInDomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\OptInDomain::class, $num_records)->create();
    }
}
