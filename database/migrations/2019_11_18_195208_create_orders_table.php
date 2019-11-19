<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->enum('status', [
				\App\Models\Order::STATUS_PENDING,
				\App\Models\Order::STATUS_PROCESSING,
				\App\Models\Order::STATUS_COMPLETED,
				\App\Models\Order::STATUS_ON_HOLD,
				\App\Models\Order::STATUS_CANCELED,
			])->index();
			$table->string('title')->index();
			$table->text('description');
			$table->string('image')->nullable();
			$table->text('comment')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('orders');
	}
}
