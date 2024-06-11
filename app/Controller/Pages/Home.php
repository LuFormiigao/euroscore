<?php 

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Home extends Page{
    
    /**
     * Responsável por retornar o conteúdo (view) da pg home
     * @return string
     */
    public static function getHome(){
        // Organização
        $obOrganization = new Organization;
        //view da Home
        $content = View::render('pages/home',[
        'name' => $obOrganization->name,
        'site' => $obOrganization->site
        ]);
        // Retorna a View da pagina
      return parent::getPage('Euroscore | Projeto', $content);
    }

}