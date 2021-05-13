<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    
    function __construct(int $projeto_id, string $propriedade_alterada, string $alteracao_realizada = "preenchido", string $valor_anterior, string $valor_novo, int $alterado_por) 
    {
        $this->projeto_id = $projeto_id;
        $this->propriedade_alterada = $propriedade_alterada;
        $this->alteracao_realizada = $alteracao_realizada;
        $this->valor_anterior = $valor_anterior;
        $this->valor_novo = $valor_novo;
        $this->alterado_por = $alterado_por;
    }
}
