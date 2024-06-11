<?php 

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router{

  /**
   * URL completa da projeto
   * @var string
   */
  private $url = '';

  /**
   * Prefixo de todas as rotas
   * @var string
   */
  private $prefix = '';

  /**
   * Indice de rotas
   * @var array
   */
  private $routes = [];

  /**
   * Instancia de request
   * @var Request
   */
  private $request;

  /**
   * Método responsavel por iniciar a classe
   * @param string $url
   */
  public function __construct($url){
    $this->request = new Request($this);
    $this->url     = $url;
    $this->setPrefix();  
  }

  /**
   * Metodo responsavel por definir o prefixo das rotas
   */
  private function setPrefix() {
    //Informaçoes da url atual
    $parseUrl = parse_url($this->url);

    //Define o prefixo
    $this->prefix = $parseUrl['path'] ?? '';
  }

  /**
   * metodo responsavel por adicionar uma rota na classe
   * @param string $method
   * @param string $route
   * @param array @params
   */
  private function addRoute($method,$route,$params = []) {
    //Validaão dos parametros
    foreach($params as $key=>$value){
      if($value instanceof Closure){
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }

    //Middlewares da ROTA
    $params['middlewares'] = $params['middlewares'] ?? [];

    //VARIAVEIS DA ROTA
    $params['variables'] = [];

    //Padrão de validacão das variaveis das rotas
    $patternVariable = '/{(.*?)}/';
    if(preg_match_all($patternVariable,$route,$matches)) {
      $route = preg_replace($patternVariable,'(.*?)',$route);
      $params['variables'] = $matches[1];
    }

    //Padrão de validaçao da URL
    $patternRoute = '/^'.str_replace('/','\/',$route). '$/';

    //Adiciona a ROTA dentro da classe
    $this->routes[$patternRoute][$method] = $params;
  }

  /**
   * Metodo responsavel por definir uma rota de get
   * @param string $route
   * @param array $params
   */
  public function get($route,$params = []) {
    return $this->addRoute('GET',$route,$params);
  }

  /**
   * Metodo responsavel por definir uma rota de POST
   * @param string $route
   * @param array $params
   */
  public function post($route,$params = []) {
    return $this->addRoute('POST',$route,$params);
  }

  /**
   * Metodo responsavel por definir uma rota de PUT
   * @param string $route
   * @param array $params
   */
  public function put($route,$params = []) {
    return $this->addRoute('PUT',$route,$params);
  }

  /**
   * Metodo responsavel por definir uma rota de DELETE
   * @param string $route
   * @param array $params
   */
  public function delete($route,$params = []) {
    return $this->addRoute('DELETE',$route,$params);
  }

  /**
   * Metodo responsavel por retornar a uri desconsiderando o prefixo
   * @return string
   */
  public function getUri() {
    //URI da requst
    $uri = $this->request->getUri();


    // Fatia a URI com o prefixo
    $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];
    
    //Retorna a URI se prefixo
    return end($xUri);
  }

  /**
   * Metodo resposnavel por retornar o dados da rota atual
   * @return array
   */
  private function getRoute(){
    //URI
    $uri = $this->getUri();

    //METHOD
    $httpMethod = $this->request->getHttpMethod();
    
    //VALIDA AS ROTAS
    foreach($this->routes as $patternRoute=>$methods){
      //VERIFICA SE A URI BATE COM O PADRAO
     if(preg_match($patternRoute,$uri,$matches)) {
        //VERIFICA O METODO
        if(isset($methods[$httpMethod])){  
          //Remove a primeira posição
          unset($matches[0]);
          //Variaveis processados
          $keys = $methods[$httpMethod]['variables'];
          $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
          $methods[$httpMethod]['variables']['request'] = $this->request;

          //Retorno dos parametros da rota
          return $methods[$httpMethod];
      }
      //Metodo nao permitido definido
      throw new Exception("Método não permitido", 405);
     }
    }
    //URL Não encontrada
    throw new Exception("URL Não encontrada", 404);
  }

  /**
   * Metodo responsavel por executar a rota atual
   * @return Response
   */
  public function run(){
    try {    
      //OBTEM A ROTA ATUAL
      $route = $this->getRoute();
       
      //VERIFICA O CONTROLADOR
      if(!isset($route['controller'])){
        throw new Exception("A URL não pôde ser processada", 500);     
      }

      // Argumetnos da função
      $args = [];

      //Reflection
      $reflection = new ReflectionFunction($route['controller']);
      foreach($reflection->getParameters() as $parameter){
       $name = $parameter->getName();
       $args[$name] = $route['variables'][$name] ?? '';
      }

    //Retorna a execução da fila de middlewares
    return (new MiddlewareQueue($route['middlewares'],$route['controller'],$args))->next($this->request);
    }catch(Exception $e) {
      return new Response($e->getCode(),$e->getMessage());
    }
  }
  /**
   * Método responsavel por redirecionar a url
   * @param string $route
   */
  public function redirect($route){
    //URL
    $url = $this->url.$route;
    
    //EXECUTA O REDIRECT
    header('location: '.$url);
    exit;
  }
}
 


?>