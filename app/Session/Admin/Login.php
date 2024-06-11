<?php 

namespace App\Session\Admin;

class Login{

  /**
   * Método responsavel por iniciar a sessão
   */
  private static function init(){
    //VERIFICA SE A SESSÃO NÃO ESTA ATIVA
    if(session_start() != PHP_SESSION_ACTIVE){
      session_start();
    }
  }

  /**
   * Metodo responsavel por criar o login do usuario
   * @param User $obUser
   * @return boolean
   */
  public static function login($obUser){
    //Inicia a sessão
    self::init();

    //Define a sessão do usuario
    $_SESSION['admin']['usuario'] = [
      'id_usuario' => $obUser->id_usuario,
      'nome' => $obUser->nome,
      'email' => $obUser->email
    ];

    //SUCESSO
    return true;
  }

  /**
   * Metodo responsavel por verificar se o usuario esta logado
   * @return boolean
   */
  public static function isLogged(){
    //Inicia a sessao
    self::init();

    //retorna a verificaçao
    return isset($_SESSION['admin']['usuario']['id_usuario']);
  }

  /**
   * Método responsavel por executar logout do usuario
   * @return boolean
   */
  public static function logout(){
        //Inicia a sessao
        self::init();

        //Delosga o usuario
        unset($_SESSION['admin']['usuario']);
        
        //Sucesso
        return true;
  }
}

?>