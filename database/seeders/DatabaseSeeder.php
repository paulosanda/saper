<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\Telefone;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Agenda::factory()->count(100)->create();

        $agendas = Agenda::all();

        foreach ($agendas as $agenda) {
            Telefone::factory()->create([
                'agenda_id' => $agenda->id
            ]);
        }
    }
}
