<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Noticias extends page { 
    /**
     * Responsável por retornar o conteúdo (view) da pagina de noticias
     * @return string
     */
    public static function getNoticias(){
      // Organização
      $obOrganization = new Organization;
      //view da Home
      $content = View::render('pages/noticias',[
      'name' => $obOrganization->name,
      ]);
      // Retorna a View da pagina
    return parent::getPage('Euroscore | Noticias', $content);
  }

}
?>