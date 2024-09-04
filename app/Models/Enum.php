<?php

namespace App\Models;

enum Enum: string {
    case SUCESSO = 'sucesso';
    case PENDENTE = 'pendente';
    case PROCESSANDO = 'processando';
    case CONCLUIDO = 'concluído';
    case CANCELADO = 'cancelado';
}
