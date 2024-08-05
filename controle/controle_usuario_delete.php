<?php

USE Firebase\JWT\MeutokenJWT;
require_once("modelo/Banco.php");
require_once("modelo/Usuario.php");
require_once("modelo/MeutokenJWT.php");


$headers = apache_request_headers();
$objtoken = new MeutokenJWT();
$objResposta = new stdClass();
$objUsuario = new Usuario();

try{
    if ($objtoken->validarToken($headers['Authorization']) == true) {
        $objUsuario->setIdUsuario($parametro_idusuario);

        if ($objUsuario->delete() == true ){
            header('HTTP/1.1 204');

        }else{
            header('HTTP/1.1 200');
            header('content-type : application/json');
        }
    }else{
        $objResposta->status = 'false';
        $objResposta->codigo = 1;
        $objResposta->msg= 'Falha ao excluir! Token invalido'; 
    }
}catch (Exception $e) {
        $objResposta->codigo = 1;
        $objResposta->status = false;
        $objResposta->erro = $e->getMessage();
        die(json_encode($objResposta));
    
    }
echo json_encode($objResposta);

?>