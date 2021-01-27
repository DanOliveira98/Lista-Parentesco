<?php

class desafioTurim
{
    public function criarDb()
    {

    }

    public function conectar()
    {

    }

    public function salvar($json)
    {

    }

    public function retornaJson()
    {

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
    <title>Desafio Turim</title>
</head>
<body>
<div class="mt-2">

    <button class="btn">Gravar</button>
    <button class="btn" onclick="listar();">Ler</button>
    <br>
    <br>
    <div>
        <label for="name">Nome</label>
        <input type="text" id="name" name="name" class="">
        <button onclick="incluir();" class="btn">Inlcuir</button>
        <div class="row">
            <div class="col-lg-3">
                <table id="tabela" style="display: none" class="col-12">
                    <div class="col-12">
                        <thead>
                        <tr class="text-center">
                            <th>Pessoas</th>
                        </tr>
                        </thead>
                    </div>
                    <tbody id="corpo_tabela" class="col-12">
                    </tbody>
                </table>
            </div>
            <div class="col-lg-7">
                <textarea name="" id="json" cols="100" rows="15"></textarea>
            </div>
        </div>
    </div>
</div>
</body>
</html>


<script>
    var pessoas = {'pessoas': []};

    function incluir() {
        var name = document.getElementById("name").value;
        pessoas.pessoas.push({'name': name, 'filhos': []});
        console.log(pessoas);
        document.getElementById('tabela').style.display = 'block';
        var corpo = document.getElementById('corpo_tabela');
        var div = document.createElement('div');
        div.setAttribute('id', 'div_'+name);
        var linha = document.createElement('tr');
        linha.setAttribute('id', name);
        linha.classList.add('row', 'mt-3');
        var sublinha = document.createElement('td');
        sublinha.classList.add('col-12');
        sublinha.setAttribute('id', 'sublinha_'+name);
        var linhaBotao = document.createElement('button');
        var filho = document.createElement('button');
        filho.classList.add('mt-2', 'col-12');
        linhaBotao.setAttribute('class', '_button');
        linhaBotao.classList.add('col-8', 'ml-5');
        linhaBotao.setAttribute('id', 'id_' + name);
        linhaBotao.addEventListener('click', remove);
        filho.addEventListener('click', inserirFilho);
        filho.setAttribute('id', 'id_filho_' + name);
        filho.setAttribute('style', 'width: 280px;');
        var nameBotao = document.createTextNode('Remover');
        var botaoFilho = document.createTextNode('Adicionar Filho');
        sublinha.append(name);
        sublinha.append(linhaBotao);
        filho.append(botaoFilho);
        linhaBotao.append(nameBotao)
        linha.appendChild(sublinha);
        div.appendChild(linha);
        filho ? div.appendChild(filho) : null;
        corpo.appendChild(div);
        pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
    }

    function remove(event) {
        console.log(event);
        const element = event.target.id;
        console.log(element);
        const item = element.split('_').pop();
        console.log(item);
        document.getElementById(item).style.display = 'none';
        const arPessoa = pessoas.pessoas.filter(resp => resp.name != item);
        pessoas.pessoas = arPessoa;
        pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
    }

    function inserirFilho(event) {
        console.log(event);
        const filho = prompt('Informe o nome');
        const element = event.target.id;
        const item = element.split('_').pop();
        const arPessoa = [];
        arPessoa.push(pessoas.pessoas.find(resp => resp.name == item));
        console.log(arPessoa[0].filhos);
        arPessoa[0].filhos.push({
                'name': filho
        });
        console.log(arPessoa);
        pessoas.pessoas[arPessoa] = arPessoa;
        console.log(pessoas.pessoas[arPessoa][0].name);
        let corpo = document.getElementById(pessoas.pessoas[arPessoa][0].name);
        console.log(corpo);
        let linha = document.createElement('td');
        linha.classList.add('col-12');
        linha.append(filho);
        let linhaBotao = document.createElement('button');
        linhaBotao.setAttribute('class', '_button');
        linhaBotao.setAttribute('id', 'id_' + name);
        linhaBotao.classList.add('col-8', 'ml-5');
        var nameBotao = document.createTextNode('Remover filho');
        linhaBotao.append(nameBotao);
        linhaBotao.addEventListener('click', removeFilho);
        linha.appendChild(linhaBotao);
        corpo.appendChild(linha);
        pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
    }
    function removeFilho(event){
        console.log(event);
        const element = event.target.id;
        console.log(element);
        const item = element.split('_').pop();
        console.log(item);
    }

</script>