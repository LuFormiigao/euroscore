<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;

class Home extends Page {

    /**
     * Método responsável por renderizar a view de home do painel
     * @param Request $request
     * @return string
     */
    public static function getHome($request){
        // Obtém os dados do usuário logado
        $userData = SessionAdminLogin::getUser();


        // Verifica se $userData é um array associativo com os dados esperados
        if (!is_array($userData) || !isset($userData['nome'], $userData['email'])) {
            // Se não for um array válido com os dados esperados, redirecione para o login
            $request->getRouter()->redirect('/admin/login');
        }

        // Conteúdo da home
        $content = View::render('admin/modules/home/index', [
            'nome' => $userData['nome'],
            'email' => $userData['email']
        ]);

        // Retorna a página completa
        return parent::getPanel('Euroscore | Perfil', $content, 'home');
    }    

}
?>