<?php

use Illuminate\Database\Seeder;

class GreylistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\Greylist::class, $num_records)->create();
    }
}
