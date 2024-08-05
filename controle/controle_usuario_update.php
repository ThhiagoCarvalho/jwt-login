<?php
use Firebase\JWT\MeuTokenJWT;
require_once("modelo/Banco.php");
require_once("modelo/Usuario.php");
require_once("modelo/MeutokenJWT.php");



$textorecibido =file_get_contents("php://input");
$objJson = json_decode($textorecibido) or die  ('{"msg":"formato incorreto!"}');;
$headers = apache_request_headers();

$objResposta = new stdClass();
$objUsuario = new Usuario();
$objtoken = new MeutokenJWT();


if ($objtoken->validarToken($headers['Authorization']) == true) {
    $objUsuario->setIdUsuario($parametro_idusuario);

    $objUsuario -> setNomeUsuario($objJson->usuario->nomeUsuario);
    $objUsuario->setEmail($objJson->usuario->emailUsuario);
    $objUsuario -> setSenha($objJson->usuario->senha);
    $objUsuario->setNascimento($objJson->usuario->nascimento);

    try{
        if ($objUsuario->verficarUsuarioSenha()==true){

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
                $objResposta->msg = "Erro! o email do usuario nao pode ser o mesmo";
                $objResposta-> cod =4;
            }else if ($objUsuario->update()== true) {
                $objResposta-> status = true;
                $objResposta->msg = "Atualizado com sucesso!";
                $objResposta-> cod = 3;
            }else{
                $objResposta-> status = false;
                $objResposta->msg = "Erro ao cadastrar!";
                $objResposta-> cod =5;
            }
    
        }else{
            $objResposta-> status = false;
            $objResposta->msg = "Token invalido";
            $objResposta-> cod =6;
        }


        if( $objResposta->status == true) {
            header('HTTP/1.1 201');

        }else {
            header('HTTP/1.1 200');

        }
    } catch (Exception $e) {
        // Trata a exceção
        $objResposta = new stdClass();
        $objResposta->cod = 1;
        $objResposta->status = false;
        $objResposta->erro = $e->getMessage();
        //echo json_encode($objResposta);
        die(json_encode($objResposta));

    }
}
    
echo json_encode($objResposta);

?>