<?php 

namespace App\Controller\Pages;
use \App\Utils\View;

class Page{
    
    /**
     * Responsável por retornar o conteúdo (view) da pg home
     * @return string
     */
    public static function getPage($title,$content){
        return View::render('pages/corpo',[
        'title' => $title,
        'content' => $content,
        ]);

    }

}