<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Session\Admin\Login as SessionAdminLogin;

class Page {

  private static $modules = [
    'admin' => [
      'home' => [
        'label' => 'Home',
        'link' => URL.'/admin'
      ],
      'comentarios' => [
        'label' => 'Comentarios',
        'link' => URL.'/admin/comentarios'
      ],
      'users' => [
        'label' => 'Usuários',
        'link' => URL.'/admin/usuarios'
      ],
    ],
    'comum' => [
      'home' => [
        'label' => 'Home',
        'link' => URL.'/admin'
      ],
    ]
  ];

  public static function getPage($title, $content) {
    return View::render('admin/page', [
      'title' => $title,
      'content' => $content
    ]);
  }

  /**
   * Metodo responsavel por renderizar o layout de paginação
   * @param Request $request
   * @param Pagination $pagination
   * @return string
   */
  public static function getPagination($request,$obPagination){
    //PÁGINAS
    $pages = $obPagination->getPages();

    //VERIFICA A QUANTIDADE DE PAGINAS
    if(count($pages) <= 1) return '';

    //LINKS
    $links = '';
    //URL ATUAL (SEM GETS)
    $url = $request->getRouter()->getCurrentUrl();

    //GET
    $queryParams = $request->getQueryParams();

    //Renderiza os links
    foreach($pages as $page){
      //ALTERA A PÁGINA
      $queryParams['page'] = $page['page'];

      //link
      $link = $url.'?'.http_build_query($queryParams);

      //view
      $links .= View::render('admin/pagination/link', [
        'page'    => $page['page'],
        'lnik'    => $link,
        'page'    => $page['current'] ? 'active' : ''
      ]);
    }
    //renderização da box de paginação
    return View::render('admin/pagination/box', [
      'links' => $links
    ]);
  }


  private static function getMenu($currentModule, $nivel_acesso) {
    $modules = self::$modules[$nivel_acesso];
    $links = '';

    foreach ($modules as $hash => $module) {
      $links .= View::render('admin/menu/link', [
        'label' => $module['label'],
        'link' => $module['link'],
        'current' => $hash == $currentModule ? 'danger' : ''
      ]);
    }

    return View::render('admin/menu/box', [
      'link' => $links
    ]);
  }

  public static function getPanel($title, $content, $currentModule) {
    $userData = SessionAdminLogin::getUser();
    $nomeUsuario = isset($userData['nome']) ? $userData['nome'] : '';
    $nivel_acesso = isset($userData['nivel_acesso']) ? $userData['nivel_acesso'] : '';

    $contentPanel = View::render('admin/panel', [
      'menu' => self::getMenu($currentModule, $nivel_acesso),
      'content' => $content,
      'dados' => $nomeUsuario
    ]);

    return self::getPage($title, $contentPanel);
  }
}

?>