<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

$objResposta = new stdClass();
$usuario = new Categoria();

$usuario->setNomeCategoria($objJson->categoria->nomeCategoria);
        
if ($usuario->getNomeCategoria() == "") {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser vazio";
} 
else if (strlen($usuario->getNomeCategoria()) < 3) {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser menor do que 3 caracteres";
} 
else if ($usuario->isCategoria() == true) {
    $objResposta->cod = 3;
    $objResposta->status = false;
    $objResposta->msg = "Ja existe um cargo cadastrado com o nome: " . $funcionario->getNomeCategoria();
} 
else {
    // Verifica se a criação do novo cargo foi bem-sucedida
    if ($usuario->create() == true) {
        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "cadastrado com sucesso";
        $objResposta->novoCategoria = $usuario;
    } 
    // Se houver erro na criação do cargo, define a mensagem de erro
    else {
        $objResposta->cod = 5;
        $objResposta->status = false;
        $objResposta->msg = "Erro ao cadastrar novo Cargo";
    }
}

// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");

if ($objResposta->status == true) {
    header("HTTP/1.1 201");
} else {
    header("HTTP/1.1 200");
}
echo json_encode($objResposta);

?>
