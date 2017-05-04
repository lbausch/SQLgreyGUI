<?php

use Illuminate\Database\Seeder;

class AwlDomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $num_records = rand(333, 777);

        factory(\SQLgreyGUI\Models\AwlDomain::class, $num_records)->create();
    }
}
