<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estacionamento>
 */
class EstacionamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->name,
            'razaosocial' => $this->faker->name,
            'cnpj' => $this->faker->name,
            'idendereco' => $this->faker->name,
            'vagas' => $this->faker->name,
            'whatssap' => $this->faker->name,
            'mensagem' => $this->faker->name,
        ];
    }
}
