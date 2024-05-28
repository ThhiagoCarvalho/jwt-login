<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");

$objResposta = new stdClass();
$usuario = new Categoria();
$usuario->setIdCategoria($parametro_idCategoria);

$vetor = $usuario ->readByID();

$objResposta->cod = 1;
$objResposta->status = true;
$objResposta->msg = "executado com sucesso";
$objResposta->cargos = $vetor;

// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);

?>
