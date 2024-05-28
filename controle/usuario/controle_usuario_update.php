<?php
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");
require_once ("modelo/Usuario.php");

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

$objResposta = new stdClass();
$objetoUsuario = new Usuario();
$objetoCategoria  = new Categoria();

$objetoCategoria ->setIdCategoria( $objJson->usuario->Categoria_idCategoria );

$objetoUsuario->setIdUsuario($parametro_idUsuario);
$objetoUsuario->setNomeUsuario($objJson->usuario->nomeUsuario);
$objetoUsuario->setCategoriaDate($objJson->usuario->categoriaDate);
$objetoUsuario->setDataDate($objJson->usuario->dataDate);
$objetoUsuario->setLocalizacaoDate($objJson->usuario->localizacaoDate);

$objetoCategoria->setIdCategoria($objJson->usuario->Categoria_idCategoria);
$objetoUsuario-> setCategoria($objetoCategoria);

if ($objetoUsuario->getNomeUsuario() == "") {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser vazio";
}
// Verifica se o nome do funcionário possui menos de 3 caracteres
else if (strlen($objetoUsuario->getNomeUsuario()) < 3) {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->msg = "o nome nao pode ser menor do que 3 caracteres";

}else if ($objetoUsuario->isData() == true) {
        $objResposta->cod = 3;
        $objResposta->status = false;
        $objResposta->msg = "Ja existe uma data ocupada por alguem";
     
} else {
    if ($objetoUsuario->update() == true) {
        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "Atualizado com sucesso";
        $objResposta->categoriaAtualizado = $usuario;
    } else {
        // Define os atributos da resposta indicando erro
        $objResposta->cod = 5;
        $objResposta->status = false;
        $objResposta->msg = "Erro ao atualizar usuario";
    }
}
// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);
?>