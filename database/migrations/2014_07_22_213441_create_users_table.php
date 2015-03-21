<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * table name
     * 
     * @var string 
     */
    private $table = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create($this->table, function(Blueprint $table) {
            // primary key
            $table->increments('id')->unsigned();

            $table->string('username', 250);
            $table->string('password', 250);
            $table->string('email', 250);

            $table->boolean('enabled')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists($this->table);
    }

}
