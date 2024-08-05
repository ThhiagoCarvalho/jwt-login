<?php
use Firebase\JWT\MeuTokenJWT;
require_once ("modelo/MeuTokenJWT.php");
require_once("modelo/Banco.php");
require_once("modelo/Usuario.php");
try {
    $headers = apache_request_headers(); 

    $objResposta = new stdClass();
    $tokenJWT = new MeuTokenJWT();

    if ($tokenJWT->validarToken($headers['Authorization']) == true) {
        $objUsuario = new Usuario();
        $objUsuario->setIdUsuario($pagina);
        $objResposta->status = true;
        $objResposta->msg = "executado com sucesso!";
        $objResposta->dados = $objUsuario->ReadByPage($pagina);
        echo json_encode($objResposta);


    }else{
        $objResposta->status = false;
        $objResposta->msg = "falhado com sucesso!";
        echo json_encode($objResposta);
    }

    header("HTTP/1.1 200");
    // Define o tipo de conteúdo da resposta como JSON
    header("Content-Type: application/json");
    echo json_encode($objResposta);
} catch (Exception $e) {
    $objResposta = new stdClass();
    $objResposta->erro = $e->getMessage();
    echo json_encode($objResposta);
}
?>