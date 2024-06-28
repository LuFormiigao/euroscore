<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page {

    /**
     * Metodo Responsável por retornar o conteúdo (view) da página de Registro/Login
     * @param  Request $request
     * @param  string $errorMessage
     * @return string
     */
    public static function getLogin($request, $errorMessage = null){
        // STATUS
        $status = !is_null($errorMessage) ? Alert::getError($errorMessage) : '';

        // Conteúdo da página de login
        $content = View::render('admin/login',[
            'status' => $status,
            'userName' => SessionAdminLogin::getUser()['nome'] ?? '' // Exibe o nome do usuário, se estiver definido
        ]);

        // Retorna a Página completa
        return parent::getPage('Login | EuroScore', $content);
    }

    /**
     * Metodo responsavel por definir o login do usuario
     * @param Request $request
     */
    public static function setLogin($request){
        // POST VARS
        $postVars = $request->getPostVars();
        $email    = $postVars['email'] ?? '';
        $senha    = $postVars['senha'] ?? '';

        // Busca usuário pelo email
        $obUser = User::getUserByEmail($email);
        if (!($obUser instanceof User) || !password_verify($senha, $obUser->senha)) {
            return self::getLogin($request, 'E-mail ou senha inválidos');
        }

        // CRIA A SESSÃO DE LOGIN
        SessionAdminLogin::login($obUser);

        // Redireciona o usuário para home do admin
        $request->getRouter()->redirect('/admin');
    }

    /**
     * Metodo responsavel por deslogar o usuario
     * @param Request $request
     */
    public static function setLogout($request){
        // DESTROI A SESSÃO DE LOGIN
        SessionAdminLogin::logout();

        // Redireciona o usuário para a tela de login
        $request->getRouter()->redirect('/admin/login');
    }

     /**
     * Metodo Responsável por atualizar o perfil do usuário
     * @param  Request $request
     */
    public static function setProfile($request){
        try {
            // POST VARS
            $postVars = $request->getPostVars();
            $userData = SessionAdminLogin::getUser();
  
  
            // Busca usuário pelo email
            $obUser = User::getUserByEmail($userData['email']);
            if (!($obUser instanceof User)) {
                throw new \Exception('Usuário não encontrado');
            }
  
            // Atualiza os dados do usuário
            $obUser->nome = $postVars['nome'] ?? $obUser->nome;
            $obUser->email = $postVars['email'] ?? $obUser->email;
  
            // Verifica se a senha foi alterada
            if (isset($postVars['senha']) && strlen($postVars['senha']) > 0) {
                $obUser->senha = password_hash($postVars['senha'], PASSWORD_DEFAULT);
            }
  
            // Atualiza o usuário no banco de dados
            $obUser->update();
  
            // Atualiza os dados na sessão
            SessionAdminLogin::login($obUser);
  
            // Redireciona o usuário para a página de perfil com uma mensagem de sucesso
            $request->getRouter()->redirect('/admin?status=updated');
        } catch (\Exception $e) {
            // Em caso de erro, redireciona para página de administração com mensagem de erro
            $request->getRouter()->redirect('/admin?status=error');
        }
    }

  
}

?>