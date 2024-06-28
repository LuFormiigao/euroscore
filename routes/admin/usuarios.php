<?php 

use \App\Http\Response;
use \App\Controller\Admin;

//Rota Listagem de usuarios
$obRouter->get('/admin/usuarios',[
  'middlewares' => [
    'required-admin-login'
  ],
  function($request){
    return new Response(200,Admin\User::getUsuarios($request));
  }
]);

//Rota de edição de um usuario 
$obRouter->get('/admin/usuarios/{id}/edit',[
  'middlewares' => [
    'required-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::getEditUsuario($request,$id));
  }
]);

//Rota de edição de um usuario POST
$obRouter->post('/admin/usuarios/{id}/edit',[
  'middlewares' => [
    'required-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::setEditUsuarios($request,$id));
  }
]);


//Rota de exclusao de um usuario 
$obRouter->get('/admin/usuarios/{id}/delete',[
  'middlewares' => [
    'required-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::getDeleteUsuarios($request,$id));
  }
]);

//Rota de exclusao de um usuario POST
$obRouter->post('/admin/usuarios/{id}/delete',[
  'middlewares' => [
    'required-admin-login'
  ],
  function($request,$id){
    return new Response(200,Admin\User::setDeleteUsuarios($request,$id));
  }
]);


?>