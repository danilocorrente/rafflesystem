@extends('layouts.site')
 
@section('title', 'Page Title')
 
 
@section('content')
<section class="hero">
            <img src="{{asset('site/img/slide01.png')}}" alt="slide" class="slide">
        </section>
        <section class="sorteio-ativos" id="sorteios">
            <div class="title-section">
                <h2 class="headline-default">Confira os nossos sorteios ativos</h2>
                <p class="sub-headline">Escolha o sorteio que você quer participar.</p>
            </div>
            <div class="container-sorteios card-group">
                    @if($rifaAtiva)
                        @foreach($rifaAtiva as $rifa)
                        <article class="lance-ativo card col-md-3 col-12">
                            <img class="card-img-top" src="{{asset('uploads/'.$rifa->imagens_sorteio[0])}}" alt="Card image cap">
                            <div class="valor-lance-atual"><small>R$</small> {{number_format($rifa->valor_da_cota,2,'.',',')}}</div>
                            
                            <div class="card-body">
                                <h1 class="nome-produto-ativo">{{$rifa->nome_da_rifa}}</h1>
                                <p class="sub-headline-lance-atual">
                                    {{$rifa->descricao_curta}}<br>
                                    Compre sua cota!
                                </p>

                                <button class="btn-comprar-cota">COMPRAR COTA</button>
                            </div>
                        </article>
                        @endforeach
                    @else

                @endif

            </div>

            
        </section>
        <section class="sorteio-inativos">
            <div class="title-section">
                <h2 class="headline-default">Confira os nossos sorteios que já encerraram</h2>
                <p class="sub-headline">Escolha o sorteio que você quer participar.</p>
            </div>
            
            <div class="container-sorteios card-group">
                    @if($rifaEncerrada)
                        @foreach($rifaEncerrada as $rifa)
                        <article class="lance-ativo card col-md-3 col-12">
                            <img class="card-img-top" src="{{asset('uploads/'.$rifa->imagens_sorteio[0])}}" alt="Card image cap">
                            <div class="valor-lance-atual"><small>R$</small> {{number_format($rifa->valor_da_cota,2,'.',',')}}</div>
                            
                            <div class="card-body">
                                <h1 class="nome-produto-ativo">{{$rifa->nome_da_rifa}}</h1>
                                <p class="sub-headline-lance-atual">
                                    {{$rifa->descricao_curta}}<br>
                                    Compre sua cota!
                                </p>

                                <button class="btn-comprar-cota">COMPRAR COTA</button>
                            </div>
                        </article>
                        @endforeach
                    @else

                @endif

            </div>

        </section>
@stop