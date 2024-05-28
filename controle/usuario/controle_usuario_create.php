<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Usuario.php");
require_once ("modelo/Categoria.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

$objResposta = new stdClass();
$usuario = new Usuario();

// Define os atributos do funcionário com base nos dados recebidos do JSON
$usuario->setNomeUsuario($objJson->usuario->nomeUsuario);
$usuario->setDataDate($objJson->usuario->dataDate);
$usuario->setCategoriaDate($objJson->usuario->categoriaDate);
$usuario->setLocalizacaoDate($objJson->usuario->localizacaoDate);

// Define o ID do cargo do funcionário com base nos dados recebidos do JSON
$usuario->getCategoria()->setIdCategoria($objJson->usuario->Categoria_idCategoria);

if ($usuario->getNomeUsuario() == '') {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser vazio";
} 
// Verifica se o nome do funcionário tem menos de 3 caracteres
elseif (strlen($usuario->getNomeUsuario()) < 3) {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser menor do que 3 caracteres";
} 
// Verifica se ha uma data repetida:
else if ($usuario->isData() == true) {
    $objResposta->cod = 3;
    $objResposta->status = false;
    $objResposta->msg = "Ja existe uma data ocupada por alguem";
} 
elseif ($usuario->create() == true) {
        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "date feito com sucesso";
        $objResposta->novoUsuario = $usuario;

    } 
    // Se houver erro nodate do usuario  foi bem-sucedid, define a mensagem de erro
    else {
        $objResposta->cod = 5;
        $objResposta->status = false;
        $objResposta->msg = "Erro ao cadastrar o date ";
    }


// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");

// Define o código de status da resposta como 201 (Created) se o cadastro foi bem-sucedido, caso contrário, como 200 (OK)
if ($objResposta->status == true) {
    header("HTTP/1.1 201");
} else {
    header("HTTP/1.1 200");
}

// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);


?>
