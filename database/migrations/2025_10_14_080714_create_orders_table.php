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
        $table->id();
        $table->string('buyer_name');
        $table->string('buyer_contact');
        $table->boolean('is_paid')->default(false);
        $table->string('pickup_code')->nullable()->unique();
        $table->enum('pickup_status', ['belum_diambil', 'sudah_diambil'])->default('belum_diambil');
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
        Schema::dropIfExists('orders');
    }
}
