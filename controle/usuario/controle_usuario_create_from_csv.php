<?php

require_once ("modelo/Categoria.php");
require_once ("modelo/Usuario.php");

// Obtém o nome temporário do arquivo CSV enviado pelo formulário HTML
$nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

// Abre o arquivo CSV no modo de leitura
$ponteiroArquivo = fopen($nomeArquivo, "r");

// Variáveis para armazenar a quantidade de cargos e funcionários cadastrados
$qtdCategorias = 0;
$qtdUsuarios = 0;

// Vetores para armazenar objetos de cargos e funcionários
$usuario = array();
$categoria = array();

// Loop que lê cada linha do arquivo CSV
while (($linhaArquivo = fgetcsv($ponteiroArquivo, 1000, ";")) !== false) {
    // Converte os valores da linha para UTF-8, caso necessário
    $linhaArquivo = array_map("utf8_encode", $linhaArquivo);

    // Verifica se a categoria já existe no vetor $categorias
    $cargoExistente = false;
    foreach ($usuario as $categoria) {
        if ($categoria->getNomeCategoria() == $linhaArquivo[4]) {
            $categoriaExistente = true;
        }
    }
    // Se o cargo não existir, cria um novo objeto Categoria e adiciona ao vetor $categorias
    if ($categoriaExistente == false) {
        $usuario[$qtdCategorias] = new Categoria();
        $usuario[$qtdCategorias]->setNomeCategoria($linhaArquivo[4]);
        // Verifica se o cargo foi criado com sucesso no banco de dados
        if ($usuario[$qtdCategorias]->create() == true) {
            $qtdCategorias++;
        }
    }

    // Cria um novo objeto Usuario e define seus atributos com base nos dados do arquivo CSV
    $usuario[$qtdUsuarios] = new Usuario();
    $usuario[$qtdUsuarios]->setNomeUsuario($linhaArquivo[0]);
    $usuario[$qtdUsuarios]->setDataDate($linhaArquivo[1]);
    $usuario[$qtdUsuarios]->setCategoriaDate($linhaArquivo[2]);
    $usuario[$qtdUsuarios]->setLocalizacaoDate($linhaArquivo[3]);



    // Define o categoria do usuario
    $usuario[$qtdUsuarios]->getCategoria()->setNomeCategoria($linhaArquivo[4]);
    // Verifica se o usuario foi criado com sucesso no banco de dados
    if ($usuario[$qtdUsuarios]->createFromCSV() == true) {
        $qtdUsuarios++;
    }
}

// Cria um objeto stdClass para a resposta em JSON
$resposta = new stdClass();
$resposta->status = true;
$resposta->msg = "Cadastrados com sucesso";
$resposta->categoriaCadastrados = $usuario;
$resposta->totalCategoria = $qtdCategorias;
$resposta->totalUsuarios = $qtdUsuarios;
$resposta->UariosCadastrados = $usuario;
// Converte a resposta para JSON e a imprime
echo json_encode($resposta);
?>