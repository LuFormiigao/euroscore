<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;
use \App\Model\Entity\Comentarios as EntityComentarios;

class Comentarios extends Page { 

  // /**
  //  * Método responsavel por obter a renderizaçao dos itens de comentarios para a pagina
  //  * @param Request $obRequest
  //  * @param Pagination $obPagination
  //  * @return string
  //  */
  // private static function getComentarioItems($request,$obPagination){
  //   //Comentarios
  //   $itens = '';

  //   //QUANTIDADE TOTAL DE REGISTRO
  //   $quantidadeTotal = entityComentarios::getComentarios(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

  //   //PAGINA ATUAL
  //   $queryParams = $request->getQueryParams();
  //   $paginaAtual = $queryParams['page'] ?? 1;

  //   //INSTANCIA DE PAGINAÇAO
  //   $obPagination = new Pagination($quantidadeTotal,$paginaAtual,3);

  //   //RESULTADOS DA PAGINA
  //   $results = entityComentarios::getComentarios(null,'id DESC', $obPagination->getLimit());

  //   //RENDERIZA O ITEM
  //   while($obComentarios = $results->fetchObject($entityComentarios::class)){
  //     $itens .= View::render('pages/comentarios/item', [
  //       'nome'        =>$obComentarios->nome,
  //       'comentario'  =>$obComentarios->comentario,
  //       'postado_em'  =>date('d/m/Y H:i:s',strtotime($obComentarios->data))
  //     ]);
  //   }

  //   //Retorna os comentarios
  //   return $itens;
  // }



  /**
   * Método responsavel por renderizar a view de listagem de comentarios
   * @param Request $request
   * @return string
   */
  public static function getComentarios($request){
    //CONTEUDO DA HOME
    $content = View::render('admin/modules/comentarios/index',[]);

    //RETORNA A PAGINA COMPLETA
    return parent::getPanel('Euroscore | Comentarios', $content, 'comentarios');
  }


}
?> 