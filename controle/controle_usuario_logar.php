<?php
use Firebase\JWT\MeuTokenJWT;

require_once("modelo/Usuario.php");
require_once("modelo/MeutokenJWT.php");


$textorecibido = file_get_contents("php://input");
$objJson = json_decode($textorecibido);

$objResposta = new stdClass();
$objUsuario = new Usuario();

$objUsuario->setEmail($objJson->emailUsuario);
$objUsuario -> setSenha($objJson->senha);
$objResposta = array();

try{
    if ($objUsuario->verficarUsuarioSenha() == true) {
        $tokenJWT = new MeuTokenJWT();
        $novoToken = $tokenJWT->gerarToken(json_encode($objUsuario));
        $objResposta['status'] = 'true';
        $objResposta['msg'] = "Login efetuado com sucesso";
        $objResposta['token'] = $novoToken;

    }else{
        $objResposta['status'] = 'false';
        $objResposta['msg'] = "Falha ao login";
    }
}catch (Exception $e) {
    $objResposta = new stdClass();

    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));
    
}



echo json_encode($objResposta);
?>