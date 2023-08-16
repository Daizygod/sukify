<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $contryIds = [
            "russia" => 1
        ];
        Artist::upsert([
            ['name' => "Kizaru", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Big Baby Tape", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Morgenshtern", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Travis Scott", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Pink Guy", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Gorillaz", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Drake", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Eminem", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "OG Buda", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Playboi Carti", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Kanye West", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Элджей", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Lil Keed", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Katano Beats", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Boulevard Depo", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "PHARAOH", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Традиция", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Hella Sketchy", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Miguel", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "SQWOZ BAB", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Denzel Curry", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Scally Milano", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "DVBBS", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Flying Lotus", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "AContrari", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Looney Tunes", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "i61", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "OFFMI", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "Батерс", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "JOSHORTIZC", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
            ['name' => "GUF", 'country_id' => $contryIds["russia"], 'photo_wall_id' => 1, 'photo_cover_id' => 1, 'created_by' => 1, 'updated_by' => 1],
        ], ['name'], ['country_id', 'photo_wall_id', 'photo_cover_id', 'created_by', 'updated_by']);
    }
}
