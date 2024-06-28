<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Europa extends page { 
    /**
     * Responsável por retornar o conteúdo (view) da pagina da Champions League
     * @return string
     */
    public static function getEuropa(){
      // Organização
      $obOrganization = new Organization;
      //view da Home
      $content = View::render('pages/europa',[
      'name' => $obOrganization->name,
      ]);
      // Retorna a View da pagina
    return parent::getPage('Europa League', $content);
  }
}
?>