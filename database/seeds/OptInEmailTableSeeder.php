<?php

use Illuminate\Database\Seeder;

class OptInEmailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\OptInEmail::class, $num_records)->create();
    }
}
