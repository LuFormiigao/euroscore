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

//Rota Europa league
$obRouter->get('/europa',[
  function(){
    return new Response(200,Pages\Europa::getEuropa());
  }
]);

//Rota Noticias
$obRouter->get('/noticias',[
  function(){
    return new Response(200,Pages\Noticias::getNoticias());
  }
]);

//Rota Noticias->Noticia
$obRouter->get('/noticias/01',[
  function(){
    return new Response(200,Pages\Notice::getNotice());
  }
]);

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