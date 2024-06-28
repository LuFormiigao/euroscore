<?php 

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User as EntityUsuarios;
use \WilliamCosta\DatabaseManager\Pagination;

class User extends Page { 

  /**
   * Metodo responsavel por obter a renderizaçao dos itens de usuarios para a pagina
   * @param Request $request
   * @param Pagination $pagination
   * @return string
   */
  private static function getUserItems($request, &$obPagination){
    //USUARIOS
    $itens = '';
    //Quantidade total de usuarios
    $quantidadeTotal = EntityUsuarios::getUsuarios(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
  
    //Pagina atual
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;
  
    //Instancia de paginação
    $obPagination = new Pagination($quantidadeTotal, $paginaAtual);
  
    //Resultados da pagina
    $results = EntityUsuarios::getUsuarios(null, 'id_usuario', $obPagination->getLimit());

    //RENDERIZA O ITEM
    while ($obUser = $results->fetchObject(EntityUsuarios::class)) {
      $itens .= View::render('admin/modules/usuarios/item', [
        'id'           => $obUser->id_usuario,
        'nome'         => $obUser->nome,
        'email'        => $obUser->email,
        'nivel_acesso' => $obUser->nivel_acesso,
      ]);
    }
  
    //RETORNA OS USUARIOS
    return $itens;
  }  

  /**
   * Método responsavel por renderizar a view de listagem de usuarios
   * @param Request $request
   * @return string
   */
  public static function getUsuarios($request){
    //CONTEUDO DA HOME
    $content = View::render('admin/modules/usuarios/index',[
      'itens'       => self::getUserItems($request,$obPagination),
      'pagination'  => parent::getPagination($request, $obPagination)
      // 'status'      => self::getStatus($request)
    ]);

    //RETORNA A PAGINA COMPLETA
    return parent::getPanel('Euroscore | Usuarios', $content, 'usuarios');
  }

  /**
   * Metodo responsavel por retornar a mensagem de status
   * @param Request $request
   * @return string
   */
  private static function getStatus($request){
    //queryparams
    $queryParams = $request->getQueryParams();
    
    //status
    if(!isset($queryParams['status'])) return '';

    //mensagem de status
    switch ($queryParams['status']) {
      case 'duplicated':
        return Alert::getError('O e-mail digitado já esta sendo utilizado por outro usuário');
        break;
      case 'update':
        return Alert::getSuccess('Usuario editado com sucesso');
        break;
      case 'delete':
        return Alert::getSuccess('Usuario excluido com sucesso');
        break;       
      }
  }

  /**
   * Método responsavel por retornar formulario de edição de usuario
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function getEditUsuario($request,$id){
    //OBTEM o usuario do banco de dados
    $obUser = EntityUsuarios::getUserById($id);

    //valida a instancia
    if(!$obUser instanceof EntityUsuarios){
      $request->getRouter()->redirect('/admin/usuarios');
    }
    
    //conteudo do formulario
    $content = View::render('admin/modules/usuarios/form',[
      'title'     => 'Editar Usuário',
      'nome'      => $obUser->nome,
      'email'     => $obUser->email,
      'nivel_acesso' => $obUser->nivel_acesso,
      'status'    => self::getStatus($request)
    ]);

    //retorna a pagina completa
    return parent::getPanel('Editar Usuários | Euroscore', $content, 'usuarios');

  }

  /**
   * Metodo responsavel por gravar a atualização do usuario
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function setEditUsuarios($request,$id){
        //OBTEM o usuario do banco de dados
        $obUser = EntityUsuarios::getUserById($id);

        //valida a instancia
        if(!$obUser instanceof EntityUsuarios){
          $request->getRouter()->redirect('/admin/usuarios');
        }
        
        //POST VARS
        $postVars = $request->getPostVars();
        $nome = $postVars['nome'] ?? '';
        $email = $postVars['email'] ?? '';
        $nivel_acesso = $postVars['nivel_acesso'] ?? '';
        $senha = $postVars['senha'] ?? '';


        //valida o email do usuario
        $obUserEmail = EntityUsuarios::getUserByEmail($email);
        if($obUserEmail instanceof EntityUsuarios && $obUserEmail->id_usuario != $id){
          //redireciona o usuario
          $request->getRouter()->redirect('/admin/usuarios/'.$obUser->id_usuario.'/edit?status=duplicated');
        }

        //ATUALIZA A INSTANCIA
        $obUser->nome = $nome;
        $obUser->email = $email;
        $obUser->nivel_acesso = $nivel_acesso;
        $obUser->senha = password_hash($senha,PASSWORD_DEFAULT);
        $obUser->atualizar();

        //redireciona o usuario
        $request->getRouter()->redirect('/admin/usuarios/'.$obUser->id_usuario.'/edit?status=update');
  }

  /**
   * metodo reponsavel por retornar formulario de exclusao de um usuario
   * @param Request $request
   * @param integer @id
   * @return string
   */
  public static function getDeleteUsuarios($request,$id){
    //OBTEM o usuario do banco de dados
    $obUser = EntityUsuarios::getUserById($id);

    //valida a instancia
    if(!$obUser instanceof EntityUsuarios){
      $request->getRouter()->redirect('/admin/usuarios');
    }

        
    //conteudo do formulario
    $content = View::render('admin/modules/usuarios/delete',[
      'nome'      => $obUser->nome,
      'email'     => $obUser->email
    ]);

        //retorna a pagina completa
        return parent::getPanel('Deleta Usuários | Euroscore', $content, 'usuarios');
  }  

  /**
   * metodo reponsavel por excluir um usuario
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function setDeleteUsuarios($request,$id){
        //OBTEM o usuario do banco de dados
        $obUser = EntityUsuarios::getUserById($id);

        //valida a instancia
        if(!$obUser instanceof EntityUsuarios){
          $request->getRouter()->redirect('/admin/usuarios');
        }

        //exclui o usuario
        $obUser->excluir();

        //redireciona o usuario
        $request->getRouter()->redirect('/admin/usuarios?status=deleted');
  }

}
?> 