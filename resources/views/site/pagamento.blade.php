@extends('layouts.site')
 
@section('title', 'Regulamento')
 
 
@section('content')
<section class="objeto-body-loop">
            <div class="col1">
                <div class="tarja-title" id="tarja-azul">
                    <h2>{{$sorteio->nome_da_rifa}}</h2>
                </div>
                <div class="slider-for">
                    @if(count($sorteio->imagens_sorteio) > 1)
                        
                        @foreach ($sorteio->imagens_sorteio as $imagem)
                                <div>
                                    <img src="{{asset('uploads/'.$imagem)}}" width="100%" >
                                </div>    
                        @endforeach    
                    @endif

                </div>
                <div id="miniaturas" class="slider-nav">
                @if(count($sorteio->imagens_sorteio) > 1)
                        
                        @foreach ($sorteio->imagens_sorteio as $imagem)
                                <div>
                                    <img src="{{asset('uploads/'.$imagem)}}" width="100%" >
                                </div>    
                        @endforeach    
                    @endif
                </div>
            </div>
           
            <div class="col2">
                <div class="tarja-title" id="tarja-verde">
                    <h2>DADOS DE PAGAMENTO</h2>
                </div>
                <section class="lista-itens">
                    <h2 class="sub-title-default">REGRAS DO SORTEIO</h2>
                    <p class="regras-sorteio">O ganhador(a) será aquele(a) que tiver o número do Cupom igual aos 5 últimos números do <strong>1º Prêmio
                        da Loteria Federal.</strong><br>

                        Caso o número correspondente ao 1º Prêmio não tenha sido comercializado será considerado os 5
                        últimos números do 2º Prêmio e assim sucessivamente até o 5º Prêmio.<br>

                        Caso nenhum número do concurso tenha sido comercializado, será considerado o sorteio do próximo
                        concurso.<br>

                        <strong>OS NÚMEROS DA SORTE SÃO ENVIADOS ALEATORIAMENTE PELO SISTEMA APÓS CONFIRMAÇÃO DO PEDIDO EM ATÉ
                        72H.</strong><br><br>
                    </p>
                    <div class="dados-cliente">
                        <div class="col1-dados-cliente">
                            <h2>Cliente</h2>
                            <p>{{$op->nomeComprador}}</p><br><br>
                            <h2>Sorteio</h2>
                            <p>{{$sorteio->nome_da_rifa}}</p><br><br>
                            <h2>Status do pedido</h2>
                            <p>{{$op->status}}</p><br><br>
                        </div>
                        <div class="col2-dados-cliente">
                            <h2>Valor Total</h2>
                            <p>R$ {{number_format($op->amount,2,',','.')}}</p><br><br>
                            <h2>Data do Pedido</h2>
                            <p>{{date('d/m/Y H:i:s',strtotime($op->created_at))}}</p><br><br>
                            <h2>Pagamento até</h2>
                            <p>{{date('d/m/Y H:i:s',strtotime($op->limiteOP))}}</p><br><br>
                        </div>
                        
                    </div>
                    <div class="col-12 " style="margin-top:30px;">
                        @if($op->status == "pendente")
                            <div class="row cho-container" id="receiveMPBtn"></div>
                    @endif
                    </div>

                </section>
                <div class="cotas-sorteio">
                    <HR>
                    <h2 class="sub-title-center">COTAS DO SORTEIO {{count($numeros)}}</h2><br>
                    <div class="number-sorteio">
                    @foreach($numeros as $numeroRifa)
                        <div class="cota-number"><p>{{str_pad($numeroRifa->NumeroDaRifa , 5 , '0' , STR_PAD_LEFT)}}</p></div>
                    @endforeach

                    </div><br>
                    
                   
                </div>
            </div>

        </section>
        
@stop

@section('jquery')
@if($op->status == "pendente")
                        <script src="https://sdk.mercadopago.com/js/v2"></script>
                        <script>

                            $( document ).ready(function() {

                        // Adicione as credenciais do SDK
                        const mp = new MercadoPago("{{env('MERCADOPAGO_PUBLIC')}}", {
                                locale: 'pt-BR'
                        });

                        // Inicialize o checkout
                        mp.checkout({
                            preference: {
                                id: '{{$preference->id}}'
                            },
                            render: {
                                    container: '.cho-container', // Indique o nome da class onde será exibido o botão de pagamento
                                    label: 'EFETURAR PAGAMENTO!', // Muda o texto do botão de pagamento (opcional)
                            }
                        });
                        });

                        </script>
@endif

<script>
$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: false,
  arrows: false,
  centerMode: true,
  focusOnSelect: true
});
    </script>

@stop
