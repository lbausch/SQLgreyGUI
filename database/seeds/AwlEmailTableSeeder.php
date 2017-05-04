<?php

use Illuminate\Database\Seeder;

class AwlEmailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\AwlEmail::class, $num_records)->create();
    }
}
