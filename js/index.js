var pessoas = {'pessoas': []};

function incluir() {
    var name = document.getElementById("name").value;
    if (name){
        pessoas.pessoas.push({'name': name, 'filhos': []});
        montaTabelaPessoa(pessoas.pessoas);
    }else{
        alert('Falha na hora de salvar! Informe um nome para a Pessoa.')
    }
}

function remove(pessoa) {
    pessoa = $(pessoa);
    const element = pessoa[0].id;
    $("#" + element).hide();
    const arPessoa = pessoas.pessoas.filter(resp => resp.name != element);
    pessoas.pessoas = arPessoa;
    pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
}

function inserirFilho(pessoa) {
    const filho = prompt('Informe o nome');
    if (filho) {
        pessoa = $(pessoa);
        const item = pessoa[0].id;
        const arPessoa = [];
        arPessoa.push(pessoas.pessoas.find(resp => resp.name == item));
        arPessoa[0].filhos.push({
            'name': filho
        });
        pessoas.pessoas[arPessoa] = arPessoa;
        montaTabelaPessoa(pessoas.pessoas);
        pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
    }else{
        alert('Falha na hora de salvar! Informe um nome para o filho.')
    }
}

function removeFilho(filho, pessoa) {
    const arPessoa = [];
    arPessoa.push(pessoas.pessoas.find(resp => resp.name == pessoa));
    let arCompare = arPessoa[0];
    console.log(arPessoa);
    const arFilho = arPessoa[0]['filhos'].filter(resp => resp.name != filho);
    pessoas.pessoas.forEach(function (val, index){
        if (val == arCompare){
            pessoas.pessoas[index]['filhos'] = arFilho;
        }
    });
    if (filho){
        document.getElementById('linha_' + filho).style.display = 'none';
    }
    pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
}

function gravar() {
    console.log(pessoas.pessoas);
    if (pessoas.pessoas[0]) {
        $.ajax({
            url: window.location,
            type: 'POST',
            dataType: 'json',
            data:
                {
                    rq: 'gravar',
                    data: pessoas.pessoas
                },
            success: function (resp) {

            }
        });
        alert('Dados Salvos com sucesso!');
        document.getElementById('json').value = '';
        window.location.reload();
        return true;
    }
    alert('Sem dados para gravar');
}

function ler() {
    $.ajax({
        url: window.location,
        type: 'POST',
        dataType: 'json',
        data:
            {
                rq: 'ler',
            },
        success: function (resp) {
            pessoas.pessoas = resp;
            verificaDados(pessoas.pessoas);
        }
    });
}
function verificaDados(dados){
    console.log(dados);
    if (dados[0]){
        console.log('teste');
        montaTabelaPessoa(dados);
        return true;
    }
    alert('Tente Novamente, se o alerta ainda aparecer é porque está sem dados salvos no banco!');
    window.location.reload();
}
function montaTabelaPessoa(dados) {
    console.log(dados);
    if (dados[0]) {
        document.getElementById('tabela').style.display = 'block';
        $('#corpo_tabela').empty();
        dados.forEach(function (val, index) {
            let idDiv = "div_" + val.name;
            let idSublinha = 'sublinha_' + val.name;
            let idFilhos = 'id_filhos_' + val.name;
            const linha = $(
                "<tr class='row mt-2' id=" + val.name + " >" +
                "<td style='background-color: #d3d3d3' class='col-12' id=" + idSublinha + ">"
                + val.name +
                "<button class='col-6 float-right' onclick='remove(" + val.name + ")'>Remover</button>" +
                "<div class='col-12' id=" + idFilhos + ">" +
                "</div>" +
                "<button class='mt-2' id='inserirFilho' style='width: 300px;' onclick='inserirFilho(" + val.name + ")'>Adicionar Filho</button>" +
                "</td>" +
                "</tr>"
            );
            $('#corpo_tabela').append(linha);
            console.log(val.filhos);
            if (val.filhos) {
                montaTabelaFilho(val.filhos, '#' + idFilhos, val.name);
            }
        });
        pessoas.pessoas ? document.getElementById('json').value = JSON.stringify(pessoas) : null;
    }
}

function montaTabelaFilho(filhos, selector, pessoa) {
    if (Array.isArray(filhos)) {
        filhos.forEach(function (valor, index) {
            if (valor.name){
                let id = valor.name;
                let idFilhos = 'linha_' + valor.name;
                const filhos = $(
                    "<td style='background-color: #e0e0e0' class='mt-2 row' id='" + idFilhos + "'>"
                    + "<p class='col-6'>" + valor.name + "</p>" +
                    "<button class='col-6 float-right' onclick='removeFilho(\"" + id + "\",\"" + pessoa + "\");'>Remover Filho</button>" +
                    "</td>"
                );
                $(selector).append(filhos);
            }else{
                removeFilho(valor.name, pessoa);
            }
        });
    }else{
        let id = filhos;
        let idFilhos = 'linha_' + filhos;
        const filhos = $(
            "<td style='background-color: #e0e0e0' class='mt-2 row' id='" + idFilhos + "'>"
            + "<p class='col-6'>" + filhos + "</p>" +
            "<button class='col-6 float-right' onclick='removeFilho(\"" + id + "\",\"" + pessoa + "\");'>Remover Filho</button>" +
            "</td>"
        );
        $(selector).append(filhos);
    }
}