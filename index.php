<?php
//https://github.com/bramus/router
require_once "modelo/Router.php";

$router = new Router();

$router->post('/categorias', function () {
  require_once "controle/categoria/controle_categoria_create.php";
});

$router->delete('/categorias/(\d+)', function ($parametro_idCategoria) {

  require_once "controle/categoria/controle_categoria_delete.php";
});

$router->get('/categorias/(\d+)', function ($parametro_idCategoria) {
  require_once "controle/categoria/controle_categoria_read_by_id.php";
});

$router->get('/categorias/', function () {
  require_once "controle/categoria/controle_categoria_read_all.php";
});

$router->put('/categorias/(\d+)', function ($parametro_idCategoria) {
  require_once "controle/categoria/controle_categoria_update.php";
});


//Rotas de usuarios
$router->post('/usuarios/', function () {
  require_once "controle/usuario/controle_usuario_create.php";
});

$router->delete('/usuarios/(\d+)', function ($parametro_idUsuario) {

  require_once "controle/usuario/controle_usuario_delete.php";
});

$router->get('/usuarios/(\d+)', function ($parametro_idUsuario) {
  require_once "controle/usuario/controle_usuario_read_by_id.php";
});

$router->get('/usuarios/', function () {
  require_once "controle/usuario/controle_usuario_read_all.php";
});

$router->put('/usuarios/(\d+)', function ($parametro_idUsuario) {
  require_once "controle/usuario/controle_usuario_update.php";
});


$router->run();
