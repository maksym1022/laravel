<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	   
        Schema::table('status_logs', function ($table) {
            $table->integer('id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
        });
	}

}
