<?php
require_once("modelo/Banco.php");
require_once("modelo/Usuario.php");
$textorecibido =file_get_contents("php://input");
$objJson = json_decode($textorecibido) or die  ('{"msg":"formato incorreto!"}');;

$objResposta = new stdClass();
$objUsuario = new Usuario();

$objUsuario -> setNomeUsuario($objJson->usuario->nomeUsuario);
$objUsuario->setEmail($objJson->usuario->emailUsuario);
$objUsuario -> setSenha($objJson->usuario->senha);
$objUsuario->setNascimento($objJson->usuario->nascimento);
try{
    if ($objUsuario->getNomeUsuario() == '') {
        $objResposta-> status = false;
        $objResposta->msg = "Erro! o nome nao pode ser vazio!";
        $objResposta-> cod =1;
    }else if($objUsuario->getNomeUsuario() < 3){
        $objResposta-> status = false;
        $objResposta->msg = "Erro! o nome nao pode ser menor que 3 caracteres!";
        $objResposta-> cod =2;
    }else if ($objUsuario->IsUsuario() == true) {
        $objResposta-> status = false;
        $objResposta->msg = "Erro! Ja existe alguem com este email";
        $objResposta-> cod =4;
    }else if ($objUsuario->create()== true) {
        $objResposta-> status = true;
        $objResposta->msg = "Cadastrado com sucesso!";
        $objResposta-> cod = 3;
    }else{
        $objResposta-> status = false;
        $objResposta->msg = "Erro ao cadastrar!";
        $objResposta-> cod =5;
    }
} catch (Exception $e) {
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));

}

if( $objResposta->status == true) {
    header('HTTP/1.1 201');

}else {
    header('HTTP/1.1 200');

}

echo json_encode($objResposta);

?>