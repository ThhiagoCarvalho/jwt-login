<?php
require_once ("modelo/Usuario.php");

$objResposta = new stdClass();
$usuario = new Usuario();

$usuario->setIdUsuario($parametro_idUsuario);

if ($usuario->delete() == true) {
    header("HTTP/1.1 204");
} else {
    header("HTTP/1.1 200");
    header("Content-Type: application/json");
    $objResposta->status = false;
    $objResposta->cod = 1;
    $objResposta->msg = "Erro ao excluir usuario";
    echo json_encode($objResposta);
}
?>
