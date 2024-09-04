<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Estacionamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'razaosocial',
        'cnpj',
        'vagas',
        'whatssap',
        'mensagem',
    ];

    public function endereco()
    {
        return $this->embedsOne(Endereco::class);
    }
}
