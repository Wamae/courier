<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWaybillManifestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('waybill_manifests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('manifest')->index('manifest');
			$table->integer('waybill')->index('waybill');
			$table->integer('status');
			$table->integer('created_by')->unsigned()->index('created_by');
			$table->timestamps();
			$table->integer('updated_by')->unsigned()->nullable()->index('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('waybill_manifests');
	}

}
