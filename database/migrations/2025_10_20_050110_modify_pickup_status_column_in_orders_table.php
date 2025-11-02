<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    // Daripada ubah kolom, hapus dan tambahkan ulang secara manual:
    Schema::table('orders', function (Blueprint $table) {
        if (Schema::hasColumn('orders', 'pickup_status')) {
            $table->dropColumn('pickup_status');
        }
    });

    Schema::table('orders', function (Blueprint $table) {
        $table->string('pickup_status')->default('Belum Diambil');
    });
}


    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('pickup_status')->default(false)->change();
        });
    }
};
