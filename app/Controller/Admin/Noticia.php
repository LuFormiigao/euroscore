<?php 

namespace App\Controller\Pages;

use \App\Utils\View;

class Noticia extends Page{
  /**
   * Metodo responsavel por retornar o conteudo da view de noticas
   * @return string
   */
  public static function getNoticias(){
    //View de Noticias
    $content = View::render('pages/noticais',[
       
    ]);
    
    //Retornar a view da pagina
    return parent::getPage('Noticias | Euroscore', $content);
  }
}

?>