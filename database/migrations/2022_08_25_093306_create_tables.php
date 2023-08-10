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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('artist_id');
            $table->timestamp('release_date')->useCurrent();
            $table->integer('type');
            $table->bigInteger('counter');
            $table->integer('photo_cover_id');
            $table->integer('file_id');
            $table->integer('video_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('artist_id');
            $table->integer('track_id');
            $table->timestamp('release_date')->useCurrent();
            $table->integer('photo_cover_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('track_id');
            $table->integer('photo_cover_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('country_id');
            $table->integer('photo_wall_id');
            $table->integer('photo_cover_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('emoji');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('users_liked_songs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('track_id');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('users_liked_playlists', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('playlist_id');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables');
    }
};
