<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('swego_settings', function (Blueprint $table) {
            $table->string('shop_name', 100)->nullable()->after('album_id');
        });
    }

    public function down()
    {
        Schema::table('swego_settings', function (Blueprint $table) {
            $table->dropColumn('shop_name');
        });
    }
};
