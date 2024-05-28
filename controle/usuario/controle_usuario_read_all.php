<?php
// Inclui as classes Banco, Cargo e Funcionario, que provavelmente contêm funcionalidades relacionadas ao banco de dados, cargos e funcionários
require_once ("modelo/Banco.php");
require_once ("modelo/Categoria.php");
require_once ("modelo/Usuario.php");


// Cria um novo objeto para armazenar a resposta
$objResposta = new stdClass();

// Cria um novo objeto da classe Funcionario
$usuario = new Usuario();

// Chama o método readAll() para recuperar todos os dates do usuarios
$vetor = $usuario->readAll();

// Define os atributos do objeto resposta para indicar que a operação foi executada com sucesso e inclui o vetor de usuarios
$objResposta->cod = 1;
$objResposta->status = true;
$objResposta->msg = "executado com sucesso";
$objResposta->cargos = $vetor;

// Define o código de status da resposta como 200 (OK)
header("HTTP/1.1 200");
// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");
// Converte o objeto resposta em JSON e o imprime na saída
echo json_encode($objResposta);
?>
