<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::table('trips', function (Blueprint $table) {
        $table->integer('seat_capacity')->after('bus_name');
    });
}

public function down(): void
{
    Schema::table('trips', function (Blueprint $table) {
        $table->dropColumn('seat_capacity');
    });
}

};
