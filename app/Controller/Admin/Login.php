<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page { 
    /**
     * Metodo Responsável por retornar o conteúdo (view) da pagina de Registro/Login
     * @param  Request $request
     * @param  string $errorMessage
     * @return string
     */
    public static function getLogin($request,$errorMessage = null){
      //STATUS
      $status = !is_null($errorMessage) ? View::render('admin/login/status',[
        'mensagem' => $errorMessage
      ]) : '';

      //Conteudo da pagina de login
      $content = View::render('admin/login',[
        'status' => $status
      ]);

      // Retorna a Pagina completa
    return parent::getPage('Login | EuroScore', $content);
  }

  /**
   * metodo responsavel por definir o login do usuario
   * @param Request $request
   */
  public static function setLogin($request){
    //POST VARS
    $postVars = $request->getPostVars();
    $email    = $postVars['email'] ?? '';
    $senha    = $postVars['senha'] ?? '';

    //Busca usuario pelo email/senha
    $obUser = User::getUserByEmail($email);
    if (!($obUser instanceof User) || !password_verify($senha, $obUser->senha)) {
        return self::getLogin($request, 'E-mail ou senha inválidos');
    }

    //CRIA A SESSÃO DE LOGIN
    SessionAdminLogin::login($obUser);

    //Redireciona o usuario para home do admin
    $request->getRouter()->redirect('/admin');
  }

   /**
     * Metodo responsavel por deslogar o usuario
     * @param Request $request
     */
    public static function setLogout($request){
      //DESTROI A SESSÃO DE LOGIN
      SessionAdminLogin::logout();
  
      //Redireciona o usuario para a tela de login
      $request->getRouter()->redirect('/admin/login');
    }
  

}
?>