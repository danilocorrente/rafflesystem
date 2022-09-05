<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\RifasComprada;
use App\Models\OrdensPagamentoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use MercadoPago;

class SiteController extends Controller
{

    public function index(){
        $rifaAtiva = new Rifa();
        $rifaEncerrada = new Rifa();
        $rifaAtiva = $rifaAtiva->rifasAtivas();
        $rifaEncerrada = $rifaEncerrada->rifasEncerradas();
        return view('site.home',compact('rifaAtiva','rifaEncerrada'));
    }
    public function regulamento(){
        $a = "";
        // $rifaAtiva = new Rifa();
        // $rifaEncerrada = new Rifa();
        // $rifaAtiva = $rifaAtiva->rifasAtivas();
        // $rifaEncerrada = $rifaEncerrada->rifasEncerradas();
        return view('site.regulamento',compact('a',));
    }
    public function termos(){
        $a = "";
        // $rifaAtiva = new Rifa();
        // $rifaEncerrada = new Rifa();
        // $rifaAtiva = $rifaAtiva->rifasAtivas();
        // $rifaEncerrada = $rifaEncerrada->rifasEncerradas();
        return view('site.termos',compact('a',));
    }
    public function sorteio_show (Request $request){
        
        $sorteio = Rifa::findOrFail($request->id)->toArray();

        // dd($sorteio);
        if(count($sorteio['imagens_sorteio']) < 4){
            for ($i=0; $i <= (4 - count($sorteio['imagens_sorteio'])); $i++) { 
                array_push($sorteio['imagens_sorteio'],$sorteio['imagens_sorteio'][array_rand($sorteio['imagens_sorteio'])]);
            }
        }
        $sorteio = (object) $sorteio;

        // dd($sorteio);
        return view('site.sorteio', compact('sorteio'));

    }

    public function rifa_op (Request $request){
        $addRifas = array();


        $rifa = Rifa::findOrFail($request->input("idrifa"));
        $op = new OrdensPagamentoModel();

        $request->input("cotas");
        $op->telefoneComprador =  (int)preg_replace('/[^0-9]/', '', $request->input("celular"));
        $op->idRifa = (int)$request->input("idrifa");
        $op->quantidadeCotas = (int)$request->input("cotas");
        $op->cpfComprador = (int)preg_replace('/[^0-9]/', '', $request->input("cpf"));
        $op->emailComprador = $request->input("email");
        $op->amountUnidade = (double)$rifa->valor_da_cota;
        $op->nomeComprador = $request->input("nome");
        $op->amount = (double)($rifa->valor_da_cota * $request->input('cotas'));
        $op->status = "pendente";
        $op->limiteOP = Carbon::now()->addMinute(5)->format("Y-m-d H:i:s");

        try {
            //code...
            $op->save();
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $res = RifasComprada::where('idRifa', $op->idRifa)->where("status","disponivel")->inRandomOrder()->limit($request->input('cotas'))->get();
        $queryLastID = RifasComprada::where("idRifa",$request->input("idrifa"))->orderBy("id","DESC")->first();
        $lastNumberRifa = ($queryLastID) ? (int)$queryLastID->NumeroDaRifa : 0;

        // dd($queryLastID);
        if($rifa->forma_da_rifa == "finalmanual" ){

            if(count($res) < (int)$request->input("cotas")){
                $qtdaCriar = round(($request->input("cotas")*5.3));
                for ($i=1; $i <= $qtdaCriar; $i++) { 
                    array_push($addRifas,['status' => 'disponivel','idRifa' => $request->input("idrifa"), 'NumeroDaRifa' => $lastNumberRifa + $i]);
                }
                try {
                    RifasComprada::insert($addRifas);
                    Log::info("Criada com sucesso!");
                    //code...
                } catch (\Throwable $th) {
                    Log::error($th->getMessage);
                }
            }
        }

        $res = RifasComprada::where('idRifa', $op->idRifa)->where("status","disponivel")->inRandomOrder()->limit($request->input('cotas'))->get();


        try {
            RifasComprada::whereIn('id', $res->pluck("id"))->update([
                'celular' => (int)preg_replace('/[^0-9]/', '', $request->input("celular")),
                'cpf' => (int)preg_replace('/[^0-9]/', '', $request->input("cpf")),
                'idOP' => $op->id,'status' => 'reservado']);
            //code...
        } catch (\Throwable $th) {
            Log::error($th->getMessage);
            //throw $th;
            dd($th);
        }
        return redirect()->route('ordem-pagamento',$op->id);

    }

    
    public function ordem_pagamento(Request $request){


        $op = OrdensPagamentoModel::findOrFail($request->id);
        $numeros = RifasComprada::where("idOP",$request->id)->get();
        $preference = "";
            if($op->status != "aprovado"){
                MercadoPago\SDK::setAccessToken(env('MERCADOPAGO_ACCESSTOKEN'));
                $preference = new MercadoPago\Preference();
                $sorteio = Rifa::findOrFail($op->idRifa)->toArray();

                // dd($sorteio);
                if(count($sorteio['imagens_sorteio']) < 4){
                    for ($i=0; $i <= (4 - count($sorteio['imagens_sorteio'])); $i++) { 
                        array_push($sorteio['imagens_sorteio'],$sorteio['imagens_sorteio'][array_rand($sorteio['imagens_sorteio'])]);
                    }
                }
                $sorteio = (object) $sorteio;
        
                // Cria um item na preferência
                $item = new MercadoPago\Item();
                $item->title = 'Meu produto';
                $item->quantity = 1;
                $item->unit_price = $op->amount;
                $preference->items = array($item);
                $preference->payment_methods = array(
                    "excluded_payment_types" => array(
                      array("id" => "ticket")
                    ),
                    "installments" => 12
                  );
        
                $preference->external_reference =  $op->id;
                $preference->notification_url = "https://sorteiolegaldf.com/webhook-mp";
        
                    
                $preference->save();
            }



        return view('site.pagamento', compact('op','sorteio','preference','numeros'));


    }



    //
}
