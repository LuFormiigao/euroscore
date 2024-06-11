<?php 

namespace App\Http;

class Request{

  /**
   * Instancia do router
   * @var Router
   */
  private $router;

  /**
   * Metodo http da requisição
   * @var string
   */
  private $httpmethod;

  /**
   * Uri da pagina
   * @var string
   */
  private $uri;

  /**
   * Parametros da URL ($GET)
   * @var array
   */
  private $queryParams = [];

  /**
   * Variaveis recebidas no POST da pagina. ($_POST)
   * @var array
   */
  private $postVars = [];

  /**
   * Cabeçalho da requisição
   * @var array
   */
  private $headers = [];

  public function __construct($router) {
    $this->router      =$router;
    $this->queryParams = $_GET ?? [];
    $this->postVars    = $_POST ?? [];
    $this->headers     = getallheaders();
    $this->httpmethod  = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->setUri();
}

  /**
   * Metodo responsavel por definir a URI
   */
  private function setUri(){
    //URI COMPLETA COM GETS
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    
    //Remove gets da uri
    $xUri = explode('?',$this->uri);
    $this->uri = $xUri[0];
  }

  /**
   * Metodo responsavel por retornar a instancia de router
   * @return Router
   */
  public function getRouter(){
    return $this->router;
  }

  /**
   * Metodo responsavel por retornar o metodo http da requisisçao
   * @var string
   */
  public function getHttpMethod() {
    return $this->httpmethod;
  }

  /**
  * Metodo responsavel por retornar o metodo http da requisisçao
  * @var string
  */
 public function getUri() {
   return $this->uri;
  }

  /**
  * Metodo responsavel por retornar o metodo http da requisisçao
  * @var array
  */
  public function getHeaders() {
   return $this->headers;
  }

  /**
  * Metodo responsavel por retornar os parametros da URL da requisisçao
  * @var array
  */
 public function getQueryParams() {
  return $this->queryParams;
 }

  /**
   * Metodo responsavel por retornar o metodo POST da requisisçao
   * @var array
   */
  public function getPostVars() {
    return $this->postVars;
   }

}

?>