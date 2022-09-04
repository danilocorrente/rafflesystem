<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} | @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/reset.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/site/bootstrap/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/stylemain.css')}}" />
</head>

<body class="">
    <!-- CABEÇALHO -->
    <header class="cabecalho container-fluid">
        <div class="row">
            <div class="col-md-3 col-12">
                <a href="#"><img src="{{asset('site/img/LOGO.png')}}" alt="logotipo" id="logo"></a>
            </div>
            <div class="col-md-9 col-12">
                <nav>
                    <ul class="nav-list">
                        <li><a href="#">INÍCIO</a></li>
                        <li><a href="#" onclick="rolar_para('#sorteios')">SORTEIOS</a></li>
                        <li><a href="#">BILHETES</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        


    </header>
    <!-- CONTEÚDO -->
    <main>
        @yield('content')

        
    </main>
    <!-- RODAPÉ -->
    <footer class="rodape">
        <section class="instrucoes">
            <div class="step">
                <div class="step-icon">
                    <img src="{{asset('site/img/trofeu_icon.png')}}" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Escolha um Prêmio</h3>
                    <p>Selecione o prêmio do qual você quer concorrer na rifa.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="{{asset('site/img/ticket_icon.png')}}" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Gere seus Números</h3>
                    <p>Selecione quantos números quiser e garanta sua vitória.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="{{asset('site//img/card_icon.png')}}" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Faça o Pagamento</h3>
                    <p>Confirme o pagamento e garante os seus números da sorte.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="{{asset('site//img/feliz_icon.png')}}" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Aguarde o Sorteio</h3>
                    <p>Agora é só esperar o dia marcado paa o sorteio..</p>
                </div>
            </div>
        </section>
        <section class="sub-menus-rodape">
            <div>
                <h3>Institucional</h3>
                <ul>
                    <li><a href="#">Regulamento</a></li>
                    <li><a href="#">Termos & condições</a></li>                
                </ul>
            </div>
            <div>
                <h3>Meus números</h3>
                <ul>
                    <li><a href="#">Acompanhe o Sorteio</a></li>             
                </ul>
                <br>
                <h3>Site blindado</h3>
                <img src="{{asset('site/img/compraprotegida.png')}}">
                <img src="{{asset('site/img/googlesecure.png')}}">
            </div>
            <div>
                <h3>Formas de pagamento</h3>
                <img src="{{asset('site/img/formasdepagamento.png')}}" id="forma-de-pagamento-banner">
            </div>

        </section>
        <section class="copyright">
            <h4>© Copyright 2022 - Sorteio Master I Todos os direitos reservados</h4>
        </section>
    </footer>


    <script src="{{asset('site/plugins/jquery/jquery-3.6.1.min.js')}}"></script>
    <script src="{{asset('site/plugins/dosite/functions.js')}}"></script>
</body>

</html>