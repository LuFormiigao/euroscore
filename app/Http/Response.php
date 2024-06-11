<?php 

namespace App\Http;

class Response {

  /**
   *  Codigo status HTTP
   * @var integer
   */
  private $httpCode = 200;

  /**
   * Cabecalho do response
   * @var array
   */
  private $headers = [];

  /**
   *  Tipo de conteudo que esta sendo retornado
   * @var string
   */
  private $contentType = 'text/html';

  /**
   * Conteudo do response
   * @var mixed
   */
  private $content;

  /**
   * Metodo responsavel por iniciar a classe e definir os valores
   * @param integer $httpCode
   * @param mixed   $content
   * @param string  $contentType
   */
  public function __construct($httpCode,$content,$contentType = 'text/html')
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }

  /**
   * Metodo responsavel por alterar o content type do response
   * @param string $contentType
   */
  public function setContentType($contentType) {
    $this->contentType = $contentType;
    $this->addHeader('Content-Type',$contentType);
  }

  /**
   *  Metodo responsavel por adicionar um registro no cabecalho do response
   * @param string $key
   * @param string $value
   *    */
  public function addHeader($key,$value) {
    $this->headers[$key] = $value;
  }

  /**
   * Metodo responsavel por enviar os headers ao navegador
   */
  private function sendHeaders() {
    //STATUS
    http_response_code($this->httpCode);

    //Enviar Headers
    foreach($this->headers as $key=>$value) {
      header($key.': '.$value);
    }
  }

  /**
   * Metodo responsavel por enviar a resposta pro usuario
   */
  public function sendResponse() {
    //Enviar os headers
    $this->sendHeaders();
    //Imprime o conteudo
    switch ($this->contentType) {
      case 'text/html':
        echo $this->content;  
        exit;
    }
  }
}

?>