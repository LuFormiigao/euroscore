<?php 

use \App\Http\Response;
use \App\Controller\Pages;

//Rota HOME
$obRouter->get('/',[
  function(){
    return new Response(200,Pages\Home::getHome());
  }
]);

//Rota Champions
$obRouter->get('/champions',[
  function(){
    return new Response(200,Pages\Champions::getChampions());
  }
]);

//Rota Login
// $obRouter->get('/login',[
//   function(){
//     return new Response(200,Pages\Login::getLogin());
//   }
// ]);

//Rota Usuario
$obRouter->get('/usuario',[
  function(){
    return new Response(200,Pages\Usuario::getUsuario());
  }
]);

//Rota Usuario (INSERT)
$obRouter->post('/usuario',[
  function(){
    return new Response(200,Pages\Usuario::getUsuario());
  }
]);

//Rota Dinamica
$obRouter->get('/pagina/{idPagina}/{acao}',[
  function($idPagina,$acao){
    return new Response(200,'Página '.$idPagina. ' - '.$acao);
  }
]);
?>