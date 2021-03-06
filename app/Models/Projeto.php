<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = ['nome_projeto', 'descricao', 'url_jira', 'criado_por', 'atualizado_por'];
}
