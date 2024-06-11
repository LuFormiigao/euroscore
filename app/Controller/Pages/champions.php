<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Champions extends page { 
    /**
     * Responsável por retornar o conteúdo (view) da pagina da Champions League
     * @return string
     */
    public static function getChampions(){
      // Organização
      $obOrganization = new Organization;
      //view da Home
      $content = View::render('pages/champions',[
      'name' => $obOrganization->name,
      ]);
      // Retorna a View da pagina
    return parent::getPage('Champions League', $content);
  }
}
?>