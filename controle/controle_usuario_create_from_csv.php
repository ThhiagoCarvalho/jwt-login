<?php
use Firebase\JWT\MeuTokenJWT;
require_once("modelo/Usuario.php");
require_once("modelo/MeutokenJWT.php");

$headers = apache_request_headers();
$tokenJWT = new MeuTokenJWT();
$resposta = new stdClass();
try{
    if ($tokenJWT->validarToken($headers['Authorization']) == true) {
        $nomeArquivo = $_FILES["variavelArquivo"]["tmp_name"];

        $ponteiroArquivo= fopen($nomeArquivo,"r");
        $i=0; $objUsuario = array();


        while  ( ($linhaArquivo = fgetcsv($ponteiroArquivo,1000,";")) !== false) {
            $objUsuario[$i] = new Usuario();
            $objUsuario[$i]->setNomeUsuario($linhaArquivo[0]);
            $objUsuario[$i]->setEmail($linhaArquivo[1]);
            $objUsuario[$i]->setSenha($linhaArquivo[2]);
            $objUsuario[$i]->setNascimento($linhaArquivo[3]);
            if ($objUsuario[$i]->createFromCsv()==true){ $i++;}
        }

        $resposta->status = true;
        $resposta->msg = "Cargos cadastrados com sucesso";
        $resposta->usuarios = $objUsuario;
        $resposta->totalUsuarios = $i;
        echo json_encode($resposta);
        
    }else{
        $resposta->status = false;
        $resposta->msg = "Token invalido";
        echo json_encode($resposta);
    }
} catch (Exception $e) {
    $objResposta->codigo = 1;
    $objResposta->status = false;
    $objResposta->erro = $e->getMessage();
    die(json_encode($objResposta));

}
?>