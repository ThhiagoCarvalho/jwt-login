<?php
require_once ("modelo/Categoria.php");

// Obtém o nome temporário do arquivo CSV enviado pelo formulário HTML
$nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

// Abre o arquivo CSV no modo de leitura
$ponteiroArquivo = fopen($nomeArquivo, "r");

// Loop que lê cada linha do arquivo CSV
$qtdCategoria = 0;
$usuario = array();
while (($linhaArguivo = fgetcsv($ponteiroArquivo, 1000, ";")) !== false) {
    // Converte os valores da linha para UTF-8, caso necessário
    $linhaArguivo = array_map("utf8_encode", $linhaArguivo);

    $usuario[$qtdCategoria] = new Categoria();

    // Define o nome do cargo recebido da coluna zero do arquivo csv
    $usuario[$qtdCategoria]->setNomeCategoria($linhaArguivo[0]);

    // Chama o método para criar o cargo no banco de dados
    if ($usuario[$qtdCategoria]->create() == true) {
        $qtdCategoria++;
    }
}
$resposta = new stdClass();
$resposta->status = true;
$resposta->msg = "Cargos cadastrados com sucesso";
$resposta->cadastrados = $cargo;
$resposta->totalCargos = $qtdCargos;
echo json_encode($resposta);

?>