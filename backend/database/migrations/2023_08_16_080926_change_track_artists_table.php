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
        Schema::create('tracks_artists', function (Blueprint $table) {
            $table->foreignId('track_id')
                ->constrained('tracks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('artist_id')
                ->constrained('artists')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->unique(['track_id', 'artist_id'], 'track_artist');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks_artists');
    }
};
