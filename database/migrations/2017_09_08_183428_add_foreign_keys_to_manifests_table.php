<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToManifestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('manifests', function(Blueprint $table)
		{
			$table->foreign('created_by', 'manifests_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('updated_by', 'manifests_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('origin', 'manifests_ibfk_3')->references('id')->on('stations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('destination', 'manifests_ibfk_4')->references('id')->on('stations')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('manifests', function(Blueprint $table)
		{
			$table->dropForeign('manifests_ibfk_1');
			$table->dropForeign('manifests_ibfk_2');
			$table->dropForeign('manifests_ibfk_3');
			$table->dropForeign('manifests_ibfk_4');
		});
	}

}
