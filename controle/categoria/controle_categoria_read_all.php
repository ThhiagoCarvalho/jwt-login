<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");

$objResposta = new stdClass();
$usuario = new Categoria();
$vetor = $usuario ->readAll();

$objResposta->cod = 1;
$objResposta->status = true;
$objResposta->msg = "executado com sucesso";
$objResposta->categoria = $vetor;

header("HTTP/1.1 200");
header("Content-Type: application/json");
echo json_encode($objResposta);

?>
