<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

$objResposta = new stdClass();
$categoria = new Categoria();

$categoria->setIdCategoria($parametro_idCategoria);
$categoria->setNomeCategoria($objJson->categoria->nomeCategoria);

if ($categoria->getNomeCategoria() == "") {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser vazio";
} 
// Verifica se o nome do cargo tem menos de 3 caracteres
else if (strlen($categoria->getNomeCategoria()) < 3) {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser menor do que 3 caracteres";
} 
// Verifica se já existe um cargo cadastrado com o mesmo nome
else if ($categoria->isCategoria() == true) {
    $objResposta->cod = 3;
    $objResposta->status = false;
    $objResposta->msg = "Ja existe uma categoria cadastrado com o nome: " . $categoria->getNomeCategoria();
} 
// Se todas as condições anteriores forem atendidas, tenta atualizar o cargo
else {
    // Verifica se a atualização do cargo foi bem-sucedida
    if ($categoria->update() == true) {
        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "Atualizado com sucesso";
        $objResposta->categoriaAtualizado = $categoria;
    } 
    // Se houver erro na atualização do cargo, define a mensagem de erro
    else {
        $objResposta->cod = 5;
        $objResposta->status = false;
        $objResposta->msg = "Erro ao cadastrar nova Categoria";
    }
}
// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);
?>
