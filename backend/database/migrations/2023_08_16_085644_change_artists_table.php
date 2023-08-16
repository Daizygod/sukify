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
        Schema::table('artists', function (Blueprint $table)
        {
            $table->string('name')->unique()->change();
            $table->dropColumn("country_id");
            $table->dropColumn("photo_wall_id");
            $table->dropColumn("photo_cover_id");
            $table->dropColumn("created_at");
            $table->dropColumn("updated_at");
            $table->dropColumn("created_by");
            $table->dropColumn("updated_by");

            $table->string("avatar")->nullable();
            $table->string("background")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artists', function (Blueprint $table)
        {
            $table->string('name')->unique(false)->change();
            $table->integer("country_id");
            $table->integer("photo_wall_id");
            $table->integer("photo_cover_id");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer("created_by");
            $table->integer("updated_by");

            $table->dropColumn("avatar");
            $table->dropColumn("background");
        });
    }
};
