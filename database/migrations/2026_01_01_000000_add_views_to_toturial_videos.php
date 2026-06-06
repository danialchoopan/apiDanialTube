<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsToToturialVideos extends Migration
{
    public function up()
    {
        Schema::table('toturial_videos', function (Blueprint $table) {
            $table->integer('views')->default(0);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->integer('views')->default(0);
        });
    }

    public function down()
    {
        Schema::table('toturial_videos', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
}
