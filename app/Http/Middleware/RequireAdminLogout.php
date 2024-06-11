<?php 

namespace App\Http\Middleware;

use \App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout{

   /**
   * metodo responsavel por executar o middleware
   * @param Request $request
   * @param Closure $next
   * @return Response
   */
  public function handle($request, $next) {
    //VERIFICA SE O USUARIO ESTA LOGADO
    if(SessionAdminLogin::isLogged()){
      $request->getRouter()->redirect('/admin');
    }

    //Continua a execução
    return $next($request);
  }


}

?>