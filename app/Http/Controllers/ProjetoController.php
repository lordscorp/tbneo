<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Projeto;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Projeto::orderBy('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $novoProjeto = new Projeto($request->projeto);
        $novoProjeto->save();

        return $novoProjeto;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projeto = Projeto::find($id);
        if ($projeto) {
            return $projeto;
        }
        
        return "Projeto não encontrado.";
    }

    /**
     * Atualiza os dados do projeto
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $projeto = Projeto::find($id);

        if($projeto) {
            // Verifica quais campos foram atualizados e aplica alterações
            foreach ($request->projeto as $key => $value) {
                if($key === "atualizado_por") {
                    continue;
                }
                $valorAnterior = $projeto->$key;                
                $projeto->$key = $value;
                $log = new Log($id, $key, "preenchido", $valorAnterior, $value, $request->projeto['atualizado_por']);
                $log->save();
            }
            $projeto->save();
            return $projeto;
        }

        return "Projeto não encontrado.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projeto = Projeto::find($id);
        if($projeto) {
            $projeto->delete();
            return "Projeto excluído com sucesso.";
        }

        return "Projeto não encontrado.";
    }
}
