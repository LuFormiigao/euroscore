<?php     

namespace App\Controller\Admin;

use \App\Utils\View;

class Alert{

  /**
   * Método responsavel por retornar uma mensagem de erro
   * @param string $success
   * @return string
   */
  public static function getError($message){
    return View::render('admin/alert/status',[
      'tipo' => 'danger',
      'mensagem' => $message
    ]);
  }

/**
   * Método responsavel por retornar uma mensagem de sucesso
   * @param string $success
   * @return string
   */
  public static function getSuccess($message){
    return View::render('admin/alert/status',[
      'tipo' => 'success',
      'mensagem' => $message
    ]);
  }

}

?>