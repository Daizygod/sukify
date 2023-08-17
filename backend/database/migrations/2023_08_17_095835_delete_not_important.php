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
            $table->dropForeign('tracks_artist_id_foreign');
            $table->dropColumn('artist_id');

            $table->dropColumn('created_by');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_by');
            $table->dropColumn('updated_at');
        });

        Schema::dropIfExists('country');

        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('artist_id');
            $table->dropColumn('track_id');
            $table->dropColumn('photo_cover_id');

            $table->dropColumn('created_by');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_by');
            $table->dropColumn('updated_at');

            $table->string("cover")->nullable();
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->dropColumn('track_id');
            $table->dropColumn('photo_cover_id');

            $table->dropColumn('created_by');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_by');
            $table->dropColumn('updated_at');
        });

        Schema::table('playlists', function (Blueprint $table) {
            $table->string("cover")->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::dropIfExists('users_liked_playlists');

        Schema::create('users_liked_playlists', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('playlist_id')
                ->constrained('playlists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('created_at');
        });

        Schema::dropIfExists('users_liked_songs');

        Schema::create('users_liked_songs', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('track_id')
                ->constrained('tracks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('created_at');
        });

        Schema::create('users_liked_albums', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('album_id')
                ->constrained('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('created_at');
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

        Schema::create('playlists_tracks', function (Blueprint $table) {
            $table->foreignId('playlist_id')
                ->constrained('playlists')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('track_id')
                ->constrained('tracks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::rename('users_liked_songs', 'users_liked_tracks');

        Schema::table('tracks', function (Blueprint $table) {
            $table->bigInteger('counter')->nullable(false)->default(0)->change();
            $table->string('video_file')->nullable()->change();

            $table->dropColumn('type');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
