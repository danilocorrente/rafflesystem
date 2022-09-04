<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} | @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/reset.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('/site/css/stylemain.css')}}" />
</head>

<body>
    <!-- CABEÇALHO -->
    <header class="cabecalho">
        <a href="#"><img src="{{asset('site/img/LOGO.png')}}" alt="logotipo" id="logo"></a>
        <nav>

            <div class="mobile-menu">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>

            <ul class="nav-list">
                <li><a href="#">INÍCIO</a></li>
                <li><a href="#">SORTEIOS</a></li>
                <li><a href="#">BILHETES</a></li>
            </ul>


        </nav>

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
                    <img src="./img/trofeu_icon.png" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Escolha um Prêmio</h3>
                    <p>Selecione o prêmio do qual você quer concorrer na rifa.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="./img/ticket_icon.png" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Gere seus Números</h3>
                    <p>Selecione quantos números quiser e garanta sua vitória.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="./img/card_icon.png" alt="icone trofeu">
                </div>
                <div class="step-content">
                    <h3>Faça o Pagamento</h3>
                    <p>Confirme o pagamento e garante os seus números da sorte.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <img src="./img/feliz_icon.png" alt="icone trofeu">
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
                <img src="./img/compraprotegida.png">
                <img src="./img/googlesecure.png">
            </div>
            <div>
                <h3>Formas de pagamento</h3>
                <img src="./img/formasdepagamento.png" id="forma-de-pagamento-banner">
            </div>

        </section>
        <section class="copyright">
            <h4>© Copyright 2022 - Sorteio Master I Todos os direitos reservados</h4>
        </section>
    </footer>


</body>

</html>