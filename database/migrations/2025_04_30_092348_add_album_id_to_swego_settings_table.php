<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('swego_settings', function (Blueprint $table) {
            $table->string('album_id', 50)->nullable()->after('user_id')
                ->comment('ID альбома в системе Swego');
        });
    }

    public function down()
    {
        Schema::table('swego_settings', function (Blueprint $table) {
            $table->dropColumn('album_id');
        });
    }
};

