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
        Schema::table('tracks', function (Blueprint $table)
        {
            $table->dropColumn('artist_id');
        });

        Schema::table('tracks', function (Blueprint $table)
        {
            $table->foreignId('artist_id')
                ->constrained('artists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracks', function (Blueprint $table)
        {
            $table->dropColumn('artist_id');
        });

        Schema::table('tracks', function (Blueprint $table)
        {
            $table->integer('artist_id');
            $table->dropForeign('artist_id');//TODO test
        });
    }
};
