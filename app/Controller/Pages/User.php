<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;


class Usuario extends page { 
    /**
     * Responsável por retornar o conteúdo (view) da pagina da Champions League
     * @return string
     */
    public static function getUsuario(){
      // Organização
      $obOrganization = new Organization;
      //view da pagina de usuario
      $content = View::render('pages/usuario',[
      ]);
      // Retorna a View da pagina
    return parent::getPage('Usuario | EuroScore', $content);
  }
}
?>