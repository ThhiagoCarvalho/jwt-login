<?php
require_once ("modelo/Categoria.php");

$objResposta = new stdClass();
$categoria = new Categoria();

$categoria->setIdCategoria($parametro_idCategoria);

if($categoria->delete()==true){
    header("HTTP/1.1 204");
}else{
    header("HTTP/1.1 200");
    header("Content-Type: application/json");
    header("HTTP/1.1 200");
    header("Content-Type: application/json");
    $objResposta->status = false;
    $objResposta->cod = 1;
    $objResposta->msg = "Erro ao excluir categoria";
    echo json_encode($objResposta);
}
?>
