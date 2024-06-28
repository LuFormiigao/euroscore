<?php 

namespace App\Controller\Pages;
use \App\Utils\View;

class Page{
    
    /**
     * Responsável por retornar o conteúdo (view) da página
     * @param string $title O título da página
     * @param string $content O conteúdo da página
     * @param array $userData Os dados do usuário, se necessário
     * @return string
     */
    public static function getPage($title, $content){
        return View::render('pages/corpo',[
            'title' => $title,
            'content' => $content,
        ]);
    }

}
?>