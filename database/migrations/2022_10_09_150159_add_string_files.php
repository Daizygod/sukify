<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->string('cover_file')->nullable(false)->after('counter');
            $table->string('file')->nullable(false)->after('cover_file');
            $table->string('video_file')->nullable(false)->after('file');
        });

        if (Schema::hasColumn('tracks', 'file_id'))
        {
            Schema::table('tracks', function (Blueprint $table)
            {
                $table->dropColumn('file_id');
            });
        }

        if (Schema::hasColumn('tracks', 'photo_cover_id'))
        {
            Schema::table('tracks', function (Blueprint $table)
            {
                $table->dropColumn('photo_cover_id');
            });
        }

        if (Schema::hasColumn('tracks', 'video_id'))
        {
            Schema::table('tracks', function (Blueprint $table)
            {
                $table->dropColumn('video_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('tracks', 'cover_file'))
        {
            Schema::table('tracks', function (Blueprint $table)
            {
                $table->dropColumn('cover_file');
            });
        }

        if (Schema::hasColumn('tracks', 'file'))
        {
            Schema::table('tracks', function (Blueprint $table)
            {
                $table->dropColumn('file');
            });
        }

        if (Schema::hasColumn('tracks', 'video_file'))
        {
            Schema::table('tracks', function (Blueprint $table)
            {
                $table->dropColumn('video_file');
            });
        }
    }
};
