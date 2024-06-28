<?php 

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Comentarios{
  /**
   * Id do comentario
   * @var integer
   * 
   */
  public $id_usuario;

  /**
   * Nome do usuario que fez o comentario
   * @var string
   */
  public $nome;

  /**
   * texto do usuario que fez o comentario
   * @var string
   */
  public $comentario;

  /**
   * Data de publicaçao do comentario
   * @var string
   */
  public $postado_em;

  /**
   * Metodo responsavel por cadastrar a instancia atual no banco
   * @return booelean
   */
  public function cadastrar(){
    //Define a data
    $this->postado_em = date('Y-m-d H:i:s');

    //INSERE O DEPOIMENTO NO BANCO DE DADOS
    $this->id_usuario = (new Database('comentarios'))->insert([
      'nome' => $this->nome,
      'comentario' => $this->comentario,
      'postado_em' => $this->postado_em
    ]);
    echo "<pre>";
    print_r($this);
    echo "<pre>";exit;
    

  }
}


?>