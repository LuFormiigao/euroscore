<?php 

namespace App\Utils;

class View{

    /**
     * variaveis padroes da view
     * @var [type]
     */
    private static $vars = [];

    /**
     * Metodo responsavel por definir os dados inicias da classe 
     * @param array $vars
     */
    public static function init($vars = []) {
        self::$vars = $vars;
    }

    /**
     * Responsável pelo retorno do conteúdo da VIEW
     *
     * @param string $view
     * @return string
     */

    private static function getContentView($view){
        $file = __DIR__ .'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : ''; 
    }

    /**
     * Responsável pelo retorno do conteúdo renderizado da VIEW
     *
     * @param string $view
     * @param array  $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = []){
        // Conteudo da view
        $contentView = self::getContentView($view);

        //Merge de variaveis da VIEW
        $vars = array_merge(self::$vars,$vars);
 
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        return str_replace($keys,array_values($vars),$contentView);
    }

}