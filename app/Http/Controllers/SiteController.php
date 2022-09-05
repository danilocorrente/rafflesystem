<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\RifasComprada;
use App\Models\OrdensPagamentoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use MercadoPago;
use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
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
                $preference->notification_url = env('APP_URL')."webhook-mp";

                Log::info("Notification Url".env('APP_URL')."webhook-mp");
                // $preference->notification_url = "https://webhook.site/dde95ae3-e509-46c6-bfa9-8a5ad7b6b181";
        
                    
                $preference->save();
            }


            $cotas = $numeros->pluck("NumeroDaRifa");
            // $asCotas = "";
            // if($cotas){
                
            //     foreach($cotas as $val){
            //         $asCotas .= str_pad($val, 5, "0", STR_PAD_LEFT)."\n";
            //     }
            // }

            // $msgFormatada = "Boa noite, *{$op->nomeComprador}*,\n";
            // $msgFormatada .= "Segue as suas cotas do sorteio : *{$sorteio->nome_da_rifa}*\n";
            // $msgFormatada .= "🎟️ Cotas: \n{$asCotas}";
            // $msgFormatada .= "--------\n";
            // $msgFormatada .= "Uma boa sorte, qualquer dúvida acesse: \n";
            // $msgFormatada .= env("APP_URL");
            // $msgFormatada .= "\n\n _Este é um chat Automatizado da ferramenta, ele só serve para informativos ao consumidor_";
            // $this->sendWhatsMSG("55".$op->telefoneComprador, $msgFormatada);



        return view('site.pagamento', compact('op','sorteio','preference','numeros'));


    }

    public function webhookMP(Request $request){

        Log::info($request);
        MercadoPago\SDK::setAccessToken(env('MERCADOPAGO_ACCESSTOKEN'));

        $decode = json_decode($request->getContent(), true);
        sleep(1);
        
        if(isset($decode['data']['id'])){
            $item = MercadoPago\Payment::find_by_id($decode['data']['id']);

            // Vamos corrigir os campos agora
    
            if($item->status == "approved"){
                $op = OrdensPagamentoModel::findOrFail( preg_replace('/[^0-9]/', '', $item->external_reference));
                $op->status="aprovada";
                $op->save();
                RifasComprada::where("idOP",$op->id)->where("status","reservado")->update(['status' => 'comprado']);
            }

            $res = RifasComprada::where("idOP",$op->id)->get();

            
            
            $asCotas = "";
            if($res){
                $sorteio = Rifa::find($op->idRifa);
                
                foreach($res as $val){
                    $asCotas .= str_pad($val->NumeroDaRifa, 5, "0", STR_PAD_LEFT)."\n";
                }
            }

            $msgFormatada = "Boa noite, *{$op->nomeComprador}*,\n";
            $msgFormatada .= "Segue as suas cotas do sorteio : *{$sorteio->nome_da_rifa}*\n";
            $msgFormatada .= "🎟️ Cotas: \n{$asCotas}";
            $msgFormatada .= "--------\n";
            $msgFormatada .= "Uma boa sorte, qualquer dúvida acesse: \n";
            $msgFormatada .= env("APP_URL");
            $msgFormatada .= "\n\n _Este é um chat Automatizado da ferramenta, ele só serve para informativos ao consumidor_";
            $this->sendWhatsMSG("55".$op->telefoneComprador, $msgFormatada);

            $this->composeEmail(array("nomeDestinatario" => $op->nomeComprador,"enviarPara" => $op->emailComprador,"assunto" => "#{$op->id} | Reserva de cotas ","layout" => "mails.pagamento_confirmado","info" => array("cotas" => $res->pluck("NumeroDaRifa"))));

        }

        
    }

    public function composeEmail($request) {

        // dd($request);

        $info = $request;
        
        // echo "Fela?";
        // dd($request);
        $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = false;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = env('MAIL_IMAP');                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = env('MAIL_EMAIL');                     //SMTP username
                $mail->Password   = env('MAIL_PASSWORD');                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                //Recipients
                $mail->setFrom("automatico@sorteiolegaldf.com", "SorteioLegal");
                $mail->addAddress($request['enviarPara'], $request['nomeDestinatario']);     //Add a recipient
                $mail->addBCC('rifasdosite@sorteiolegaldf.com', 'Cópia das Rifas');
                
                

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $request['assunto'];
                $mail->Body    = view($request['layout'],compact('info'))->render();
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                // echo 'Message has been sent';
            } catch (Exception $e) {
                Log::error("Falha de Envio de E-mail {$mail->ErrorInfo}");
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }



        public function sendWhatsMSG($numero,$mensagem){

            try {
              //code...
              $client = new Client();
              $options = [
                          'verify' => false,
                          'multipart' => [
                          ['name' => 'number','contents' => $numero],
                          ['name' => 'message','contents' => $mensagem]
                          ]];
              $request = new GuzzleRequest('POST', 'https://chatbotpatriarca.correnteam.com.br/send-message');
              $res = $client->send($request, $options);
              // dd($res);
    
            } catch (\Throwable $th) {
              Log::error($th);
            }
          }




    //
}
