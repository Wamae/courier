<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToStationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stations', function(Blueprint $table)
		{
			$table->foreign('updated_by', 'stations_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'stations_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('main_office', 'stations_ibfk_3')->references('id')->on('main_offices')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stations', function(Blueprint $table)
		{
			$table->dropForeign('stations_ibfk_1');
			$table->dropForeign('stations_ibfk_2');
			$table->dropForeign('stations_ibfk_3');
		});
	}

}
