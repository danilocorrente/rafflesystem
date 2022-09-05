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
            </div>

            <div class="col2">
                <div class="tarja-title" id="tarja-verde">
                    <h2>O VALOR DA COTA É R$ {{number_format($sorteio->valor_da_cota,2,'.',',')}}</h2>
                </div>
                <section class="lista-itens">
                    <h2 class="sub-title-default">{{$sorteio->nome_da_rifa}}</h2>
                    <ul>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                        <li>Sorteios ilimitados</li>
                    </ul>

                </section>
                <div class="form-application">
                    <h2>Números da Sorte</h2>
                    <p>Selecione a quantidade de números que você deseja e em seguida aperte no botão comprar. O sistema
                        irá gerar números aleatórios e enviá-los para você no seu email após a aprovação do pagamento.
                    </p>
                    <form class="" method="POST" action="{{route('criar-ordempagamento')}}">
                        @csrf
                        <input type="hidden" name="idrifa" value="{{$sorteio->id}}">
                        <input id="nome" name="nome" type="text" class="input-ruge"  placeholder="Digite seu nome" required>

                        
                        <input id="cpf" name="cpf" type="text" class="input-ruge"  placeholder="Digite seu CPF" required>

                        <input id="email" name="email" type="email" class="input-ruge"  placeholder="Digite seu melhor e-mail" required>

                        <input id="text1" name="celular" placeholder="(xx) xxxx-xxxx" class="input-ruge" type="text" required="required" class="form-control"  placeholder="DDD + Telefone">

                        <input type="number" name="cotas" class="input-ruge" placeholder="Digite a quantidade de cotas"/>

                        <input type="submit" value="COMPRAR COTAS" style="cursor:pointer" id="btn-cotas">
                    </form>
                </div>
            </div>

        </section>
    
@stop


@section('jquery')
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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
    <script>
        $(document).on('change keyup', "input[name='cotas']", function() {
            console.log("Ola?");
            var calculo = $(this).val() * {{$sorteio->valor_da_cota}};
            calculo = calculo.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
            $("#btn-cotas").val("COMPRAR COTAS ("+calculo+") ");

        });
        $('input[name=celular]').mask('(00) 00000-0000');
        $('input[name=cpf]').mask('000.000.000-00');


    </script>

@stop