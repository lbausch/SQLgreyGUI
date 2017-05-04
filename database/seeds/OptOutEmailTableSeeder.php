<?php

use Illuminate\Database\Seeder;

class OptOutEmailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\OptOutEmail::class, $num_records)->create();
    }
}
