<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('customers', function (Blueprint $table) {
		$table->increments('id');
		$table->string('name');
		$table->integer('country_id');   
		$table->integer('city_id');
		$table->string('lang_skills');
		$table->date('date_of_birth');
		$table->string('resume');
		$table->timestamps();
		});
		Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('country_id');            
            $table->timestamps();
        });
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
		Schema::drop('countries');
        Schema::drop('cities');
    }
}
