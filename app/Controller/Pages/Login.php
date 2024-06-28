<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Login extends page { 
    /**
     * Responsável por retornar o conteúdo (view) da pagina de Registro/Login
     * @return string
     */
    public static function getLogin(){
      // Organização
      $obOrganization = new Organization;
      //view da Home
      $content = View::render('pages/login',[
      ]);
      // Retorna a View da pagina
    return parent::getPage('Registro | EuroScore', $content);
  }
}
?>