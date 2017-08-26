<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLoadingManifestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loading_manifests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('origin')->index('origin');
			$table->integer('destination')->index('destination');
			$table->string('registration_no', 30);
			$table->string('driver', 30);
			$table->string('conductor', 30);
			$table->integer('created_by')->unsigned()->index('created_by');
			$table->timestamps();
			$table->integer('updated_by')->unsigned()->nullable()->index('updated_by');
			$table->integer('status');
			$table->integer('loaded');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('loading_manifests');
	}

}
