<?php 

require __DIR__.'/includes/app.php';

use \App\Http\Router;

//Inicia o router
$obRouter = new Router(URL);

//Inclui as rotas de Páginas
include __DIR__.'/routes/pages.php';

//Inclui as rotas do PAINEL ADMINISTRADOR
include __DIR__.'/routes/admin.php';

//IMPRIME O RESPONSE DA ROTA
$obRouter->run()
->sendResponse();
