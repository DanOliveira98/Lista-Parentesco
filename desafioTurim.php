<?php
include "services/Desafio.php";
if ($_REQUEST) {
    if ($_REQUEST['rq'] == 'gravar') {
        $desafio = new Desafio();
        $tabela = $desafio->verificaTabela();
        /**
         * verificação pra saber se as tabelas já existem, não existindo, chama-se a função para criar a tabela;
         */
        if (!$tabela) {
            $desafio->criarDb();
        }
        $result = $desafio->salvar($_REQUEST['data']);
    }
    if ($_REQUEST['rq'] == 'ler') {
        $desafio = new Desafio();
        $json = $desafio->retornaJson();
        return $json;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
    <title>Lista de Parentescos</title>
</head>
<body>
<div class="mt-2">
    <button class="btn" onclick="gravar()">Gravar</button>
    <button class="btn" onclick="ler()">Ler</button>
    <br>
    <br>
    <div>
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" class="">
        <button onclick="incluir();" class="btn" id="incluir">Inlcuir</button>
        <div class="row">
            <div class="col-lg-3">
                <table id="tabela" style="display: none" class="col-12">
                    <div class="col-12">
                        <thead>
                        <tr class="text-center" style="background-color: #bdbdbd">
                            <th>Pessoas</th>
                        </tr>
                        </thead>
                    </div>
                    <tbody id="corpo_tabela" class="col-12">
                    </tbody>
                </table>
            </div>
            <div class="col-7 ml-3">
                <textarea name="" id="json" cols="80" rows="15"></textarea>
            </div>
        </div>
    </div>
</div>
</body>
</html>
