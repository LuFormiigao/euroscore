<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Register as SessionAdminRegister;

class Register extends Page {
    /**
     * Metodo responsável por retornar o conteúdo (view) da página de Registro
     * @param  Request $request
     * @param  string $errorMessage
     * @return string
     */
    public static function getRegister($request, $errorMessage = null){
        // STATUS
        $status = !is_null($errorMessage) ? Alert::getSuccess($errorMessage) : '';

        // Conteúdo da página de registro
        $content = View::render('admin/registro', [
            'status' => $status
        ]);

        // Retorna a Página completa
        return parent::getPage('Registro | EuroScore', $content);
    }

    /**
     * Metodo responsavel por registrar um novo usuario
     * @param Request $request
     */
    public static function setRegister($request){
        // POST VARS
        $postVars = $request->getPostVars();
        $name     = $postVars['nome'] ?? '';
        $email    = $postVars['email'] ?? '';
        $senha    = $postVars['senha'] ?? '';

        // Verifica se o email já está em uso
        if (User::getUserByEmail($email) instanceof User) {
            return self::getRegister($request, 'O e-mail já está em uso');
        }

        // Cria a instancia de um novo usuário
        $obUser = new User();
        $obUser->nome  = $name;
        $obUser->email = $email;
        $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);
        $obUser->save();

        // Cria a sessão de registro
        SessionAdminRegister::register($obUser);

        // Redireciona o usuario para a tela de login com sucesso
        return self::getRegister($request, 'Cadastro realizado com sucesso! Faça login.');
    }

}


?>