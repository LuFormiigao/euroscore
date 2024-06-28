<?php 

namespace App\Session\Admin;

class Login {

    /**
     * Método responsável por iniciar a sessão, se ela ainda não estiver iniciada
     */
    private static function init() {
        // Verifica se a sessão não está ativa
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Metodo responsavel por criar o login do usuario
     * @param User $obUser
     * @return boolean
     */
    public static function login($obUser) {
        // Inicia a sessão
        self::init();

        // Define a sessão do usuário com dados básicos
        $_SESSION['admin']['usuario'] = [
            'id_usuario' => $obUser->id_usuario,
            'nome' => $obUser->nome,
            'email' => $obUser->email,
            'nivel_acesso' => $obUser->nivel_acesso // Adiciona o campo nivel_acesso
        ];

        // SUCESSO
        return true;
    }

    /**
     * Metodo responsavel por verificar se o usuario esta logado
     * @return boolean
     */
    public static function isLogged() {
        // Inicia a sessão
        self::init();

        // Retorna a verificação se o usuário está logado
        return isset($_SESSION['admin']['usuario']['id_usuario']);
    }

    /**
     * Método responsavel por executar logout do usuario
     * @return boolean
     */
    public static function logout() {
        // Inicia a sessão
        self::init();

        // Desloga o usuário destruindo os dados da sessão
        unset($_SESSION['admin']['usuario']);

        // Sucesso
        return true;
    }

    /**
     * Retorna o usuário logado, se houver.
     * @return array|null Retorna um array associativo com os dados do usuário ou null se não houver usuário logado.
     */
    public static function getUser() {
      // Inicia a sessão
      self::init();

      // Verifica se o usuário está logado
      if (isset($_SESSION['admin']['usuario']['id_usuario'])) {
          // Retorna os dados do usuário
          return [
              'id_usuario' => $_SESSION['admin']['usuario']['id_usuario'],
              'nome' => $_SESSION['admin']['usuario']['nome'],
              'email' => $_SESSION['admin']['usuario']['email'],
              'nivel_acesso' => $_SESSION['admin']['usuario']['nivel_acesso'] // Retorna o campo nivel_acesso
          ];
      } 
      
      // Retorna null se não houver usuário logado
      return null;
    } 
}


?>