<?php 

namespace App\Http\Middleware;

use Exception;

class Maintenance {

  /**
   * metodo responsavel por executar o middleware
   * @param Request $request
   * @param Closure $next
   * @return Response
   */
  public function handle($request, $next) {
    //Verifica o estado de manutenção da pagina
    if(getenv('MAINTENANCE') == 'true'){
      throw new Exception("Pagina em Manutenção, tente novamente mais tarde!", 200);
    }
    //EXECUTA O PROXIMO NIVEL DE MIDDLEWARE
    return $next($request);
  }

}

?>