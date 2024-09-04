<?php

namespace Database\Seeders;

use App\Models\Estacionamento;
use Illuminate\Database\Seeder;

class EstacionamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estacionamento::factory(10)->create();
    }
}
