<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    
    protected $fillable = ['projeto_id', 'propriedade_alterada', 'alteracao_realizada', 'valor_anterior', 'valor_novo', 'alterado_por'];
}
