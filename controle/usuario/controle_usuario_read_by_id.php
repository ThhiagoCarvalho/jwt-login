<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");
require_once ("modelo/Usuario.php");

$objResposta = new stdClass();
$usuario = new Usuario();

$usuario->setIdUsuario($parametro_idUsuario);
$vetor = $usuario->readByID();

// Define os atributos do objeto resposta para indicar que a operação foi executada com sucesso e inclui o vetor de usuario
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
