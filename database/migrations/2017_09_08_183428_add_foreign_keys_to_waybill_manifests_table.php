<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToWaybillManifestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('waybill_manifests', function(Blueprint $table)
		{
			$table->foreign('manifest', 'waybill_manifests_ibfk_1')->references('id')->on('manifests')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('created_by', 'waybill_manifests_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('updated_by', 'waybill_manifests_ibfk_3')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('waybill', 'waybill_manifests_ibfk_4')->references('id')->on('waybills')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('waybill_manifests', function(Blueprint $table)
		{
			$table->dropForeign('waybill_manifests_ibfk_1');
			$table->dropForeign('waybill_manifests_ibfk_2');
			$table->dropForeign('waybill_manifests_ibfk_3');
			$table->dropForeign('waybill_manifests_ibfk_4');
		});
	}

}
