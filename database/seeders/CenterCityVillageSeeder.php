<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterCityVillageSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('city_villages')->truncate();
        DB::table('centers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Copy from gis_markazs -> centers
        $markazs = DB::table('gis_markazs')->orderBy('id')->get();
        $centerMap = []; // gis_markaz_id => new center_id

        foreach ($markazs as $m) {
            $centerId = DB::table('centers')->insertGetId([
                'name' => $m->name,
                'slug' => \Illuminate\Support\Str::slug($m->name),
                'is_active' => true,
                'sort_order' => $m->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $centerMap[$m->id] = $centerId;
        }

        // Copy from gis_shiakhas -> city_villages
        $shiakhas = DB::table('gis_shiakhas')->orderBy('gis_markaz_id')->orderBy('id')->get();
        foreach ($shiakhas as $s) {
            if (!isset($centerMap[$s->gis_markaz_id])) continue;
            DB::table('city_villages')->insert([
                'center_id' => $centerMap[$s->gis_markaz_id],
                'name' => $s->name,
                'type' => 'village',
                'is_active' => true,
                'sort_order' => $s->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo 'Copied ' . count($markazs) . " centers and " . count($shiakhas) . " villages from GIS tables.\n";
    }
}
