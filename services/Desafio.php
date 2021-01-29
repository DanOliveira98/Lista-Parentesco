<?php


class Desafio
{
    /**
     * @return mysqli|string
     */
    public function conectar()
    {
        $conn = new mysqli('localhost', 'root', 'Dan1452#', 'desafioturim');
        if ($conn->connect_error) {
            return "Connection failed: " . $conn->connect_error;
        }
        return $conn;
    }

    /**
     * @return bool|string
     */
    public function criarDb()
    {
        $conexao = $this->conectar();
        $pessoa = "CREATE TABLE pessoas (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(30) NOT NULL
                );";
//        var_dump($pessoa);die();
        if ($conexao->query($pessoa) === TRUE) {
            echo 'Criou a Tabela de';
        } else {
            return "Error creating table: " . $conexao->error;
        }
        $filhos = "CREATE TABLE filhos (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(30) NOT NULL,
                    pessoa INT(6)
                );";
        if ($conexao->query($filhos) === TRUE) {
            echo 'Criou a Tabela de Filhos';
        } else {
            echo "Error creating table: " . $conexao->error;
        }
        $fk = "alter table filhos add constraint fk_pessoa foreign key (pessoa) references pessoas (id)";
        if ($conexao->query($fk) === TRUE) {
            echo 'Criou a Tabela de Filhos';
        } else {
            echo "Error creating table: " . $conexao->error;
        }
        return true;
    }

    /**
     * @param $json
     */
    public function salvar($json)
    {

        $conexao = $this->conectar();
        $conexao->query('truncate table filhos');
        $conexao->query('truncate table pessoas');
        foreach ($json as $i => $item) {
            if ($item['name']) {
                $sql = " insert into pessoas (name) values ('{$item['name']}')";
                $conexao->query($sql);
            }
            $idPessoa = $conexao->insert_id;
            if ($item['filhos']) {
                foreach ($item['filhos'] as $filho) {
                    $sqlFilho = "insert into filhos (name, pessoa) values ('{$filho['name']}', {$idPessoa});";
                    $conexao->query($sqlFilho);
                }
            }
        }
        echo 'Dados salvos com sucesso!';
    }

    /**
     *
     */
    public function retornaJson()
    {
        $conexao = $this->conectar();
        $dados = $conexao->query("select distinct p.name as pessoas, GROUP_CONCAT((select name from desafioturim.filhos f where p.id = f.pessoa) separator  '; ') as filhos from desafioturim.pessoas p group BY p.name limit 100;");
        $dados = $dados->fetch_all();
        $json['pessoas'] = [];
        foreach ($dados as $i => $item) {
            $json['filhos'] = [];
            $json['pessoas'][$i]['name'] = $item[0];
            $isArray = preg_match("/;/", $item[1]);
            if ($isArray) {
                $filhos = explode(';', $item[1]);
                foreach ($filhos as $f => $itemFilho) {
                    $json['filhos'][]['name'] = $itemFilho;
                }
            } else {
                $json['filhos'][]['name'] = $item[1];
            }
            $json['pessoas'][$i]['filhos'] = $json['filhos'];
        }
        $json = json_encode($json['pessoas']);
        echo $json;
    }

    /**
     * @return bool
     * @description Função que verifica se as tabelas ja existem
     */
    public function verificaTabela()
    {
        $conexao = $this->conectar();
        $result = $conexao->query("show tables like 'pessoas' and tables like 'filhos'");
        return ($result->num_rows > 0);
    }
}