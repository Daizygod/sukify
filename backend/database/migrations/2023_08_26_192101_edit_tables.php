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
            $table->string('cover_file')->nullable()->change();
            $table->boolean('single')->nullable(false)->default(1);

            $table->integer('duration')->nullable(false)->default(0);
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->foreignId('album_id')
                ->nullable()
                ->constrained('albums')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->renameColumn('cover','cover_file');
            $table->integer('duration')->nullable(false)->default(0);
        });

        Schema::dropIfExists('albums_tracks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracks', function (Blueprint $table) {
            $table->string('cover_file')->nullable(false)->change();
            $table->dropColumn('single');
            $table->dropColumn('duration');

            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->renameColumn('cover_file','cover');
            $table->dropColumn('duration');
        });

        Schema::create('albums_tracks', function (Blueprint $table) {
            $table->foreignId('album_id')
                ->constrained('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('track_id')
                ->constrained('tracks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
