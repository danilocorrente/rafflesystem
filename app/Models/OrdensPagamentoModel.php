<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\RifasComprada;
use App\Models\Rifa;

class OrdensPagamentoModel extends Model
{
    protected $table = 'ordens_pagamento';
    
    use HasFactory;

    

    function pegarRifasSearch($search){
        $OpEncontradas = OrdensPagamentoModel::selectRaw("*,ordens_pagamento.created_at as criacaoOP, ordens_pagamento.id as idOP")
        ->where('ordens_pagamento.telefoneComprador', preg_replace('/[^0-9]/', '', $search))
        ->whereIn("status",['aprovada','pendente'])
        ->join('rifas','idRifa','=','rifas.id')->orderBy('criacaoOP','DESC')->get();

        // dd($OpEncontradas);
        foreach($OpEncontradas as $encontradas){
            $encontradas->cotas = RifasComprada::where("idOP",$encontradas->idOP)->get();
        }
        
        
        
        return $OpEncontradas;
        

    }

    function getOpVencidas(){
        $OpsVencidas = OrdensPagamentoModel::where("status","pendente")->whereDate('limiteOP','<=',Carbon::now()->format("Y-m-d H:i:s"))->get();

        foreach($OpsVencidas as $key => $val){
            $OP = OrdensPagamentoModel::find($val->id);
            $OP->status = 'perdida';
            $OP->save();
            try {
                RifasComprada::where("idOP",$OP->id)->update(["status" => "disponivel","cpf" => NULL, "celular" => NULL,"idOP" => NULL]);
            } catch (\Throwable $th) {
                return false;
            }
            
        }

        return $OpsVencidas;
        // return $OP;
        
        
    }

    

    public function cotas()
        {
            return $this->hasMany(RifasComprada::Class,'idOP');
        }

}
