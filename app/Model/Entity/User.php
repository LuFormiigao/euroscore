<?php 

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User{

  /**
   * ID do Usuario
   * @var integer
   */
  public $id_usuario;

    /**
   * nome do Usuario
   * @var string
   */
  public $nome;

  /**
   * email do Usuario
   * @var string
   */
  public $email;

  /**
   * Senha do Usuario
   * @var string
   */
  public $senha;

  /**
   * Metodo responsavel por retornar o usuario com base em seu email
   * @param string $email
   * @return User
   */
  public static function getUserByEmail($email){
    return (new Database('usuarios'))->select('email = "'.$email.'"')->fetchObject(self::class);
  }
}

?>