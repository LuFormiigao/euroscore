<?php 

use \App\Http\Response;
use \App\Controller\Admin;

//Rota Listagem de comentarios
$obRouter->get('/admin/comentarios',[
  'middlewares' => [
    'required-admin-login'
  ],
  function($request){
    return new Response(200,Admin\Comentarios::getComentarios($request));
  }
]);

?>