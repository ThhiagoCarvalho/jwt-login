<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once("modelo/Banco.php");
require_once("modelo/Usuario.php");


$headers = apache_request_headers();

$tokenJWT = new MeuTokenJWT();
$objResposta = new stdClass();

try {
    if ($tokenJWT->validarToken($headers['Authorization']) == true) {

        $objUsuario = new Usuario();
        $objUsuario->setIdUsuario($parametro_idusuario);
        $objResposta->status = true;
        $objResposta->msg = "executado com sucesso!";
        $objResposta->dados = $objUsuario->ReadById();
        echo json_encode($objResposta);
    }else{
        $objResposta->status = false;
        $objResposta->msg = "falhado com sucesso!";
        echo json_encode($objResposta);
    }
} catch (Exception $e) {
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));

}


header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída

?>