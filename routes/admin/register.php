<?php 

use \App\Http\Response;
use \App\Controller\Admin;

// Rota de Registro (POST)
$obRouter->post('/admin/register',[
  'middlewares' => [
      'required-admin-logout'
  ],
  function($request){
      return new Response(200, Admin\Register::setRegister($request));
  }
]);

// Rota de Registro (GET)
$obRouter->get('/admin/register',[
  'middlewares' => [
      'required-admin-logout'
  ],
  function($request){
      return new Response(200, Admin\Register::getRegister($request));
  }
]);


?>