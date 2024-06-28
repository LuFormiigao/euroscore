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
   * Nivel de acesso do usuario
   * @var string
   */
  public $nivel_acesso;

  public function save() {
    // Instância da conexão com o banco de dados
    $db = new Database('usuarios');

    // Atualiza o usuário se o ID estiver definido
    if ($this->id_usuario) {
        return $db->update('id_usuario = '.$this->id_usuario, [
            'nome'  => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);
    }

    // Insere um novo usuário
    $this->id_usuario = $db->insert([
        'nome'  => $this->nome,
        'email' => $this->email,
        'senha' => $this->senha
    ]);

    // Retorna sucesso
    return true;
}  

  /**
   * Metodo responsavel por retornar uma instancia com base no id
   * @param integer $id
   * @return User
   */
  public static function getUserById($id_usuario){
    return self::getUsuarios('id_usuario = '.$id_usuario)->fetchObject(self::class);
  }

  /**
   * Metodo responsavel por retornar o usuario com base em seu email
   * @param string $email
   * @return User
   */
  public static function getUserByEmail($email){
    return self::getUsuarios('email = "'.$email.'"')->fetchObject(self::class);
  }
  
  public function update() {
    // Instância da conexão com o banco de dados
    $db = new Database('usuarios');
    
    // Atualiza o usuário se o ID estiver definido
    if ($this->id_usuario) {
        return $db->update('id_usuario = '.$this->id_usuario, [
            'nome'  => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);
    }
    // Caso o ID do usuário não esteja definido, poderia lançar uma exceção ou retornar false
    // Aqui, dependendo da lógica da sua aplicação, você pode decidir o que fazer nesse caso
    return false;
  
}

  /**
   * Metodo responsavel por atualizar os dados no banco
   * @return boolean
   */
  public function atualizar(){
    return (new Database('usuarios'))->update('id_usuario = '.$this->id_usuario,[
      'nome'   => $this->nome,
      'email'  => $this->email,
      'nivel_acesso'  => $this->nivel_acesso,
      'senha'  => $this->senha
    ]);
  }

  /**
   * Metodo responsavel por excluir um usuario do banco
   * @return boolean
   */
  public function excluir(){
    return (new Database('usuarios'))->delete('id_usuario = '.$this->id_usuario);
}

  /**
   * Metodo responsavel por retornar usuarios 
   * @param string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   * @return PDOStatement
   */
  public static function getUsuarios($where = null, $order = null, $limit = null, $fields = '*'){
    return (new Database('usuarios'))->select($where,$order,$limit,$fields);
  }


}
?>
