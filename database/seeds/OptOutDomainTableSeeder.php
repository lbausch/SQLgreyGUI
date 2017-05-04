<?php

use Illuminate\Database\Seeder;

class OptOutDomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\OptOutDomain::class, $num_records)->create();
    }
}
