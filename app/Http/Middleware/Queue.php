<?php 

namespace App\Http\Middleware;

class Queue{
  
  /**
   * Mapeamento de middlewares
   * @var array
   */
  private static  $map = [];

  /**
   * Mapeamento de middlewares que serao carregados em todas as rotas
   * @var array
   */
  private static $default = [];

  /**
   * Fila de middlewares a ser executado
   * @var array
   */
  private $middlewares = [];

  /**
   * Função de execução do controlador
   * @var Closure
   */
  private $controller;

  /**
   * Argumentos da função do controlador
   * @var array
   */
  private $controllerArgs = [];

  /**
   * Método responsavel por construir a classe de fila de middlewars
   * @param array $middlewares
   * @param Closure $controller
   * @param array $controllerArgs
   */
  public function __construct($middlewares,$controller,$controllerArgs){
    $this->middlewares = array_merge(self::$default,$middlewares);
    $this->controller = $controller;
    $this->controllerArgs = $controllerArgs;
  }

  /**
   * Método responsavel por definir o mapeamento de middlewares
   * @param array $map
   */
  public static function setMap($map){
    self::$map = $map;
  }

   /**
   * Método responsavel por definir o mapeamento de middlewares padrões
   * @param array $default
   */
  public static function setDefault($default){
    self::$default = $default;
  }

  /**
   * Metodo responsavel por executar o proximo nivel da fila de middlewares
   * @param Request $request
   * @return Response
   */
  public function next($request){

    //Valida instancia de controller
    if (!is_callable($this->controller)) {
        throw new \Exception("Tipo esperado 'callable'. Mas veio  '...\Middleware\Closure'");
    }
    //Verifica se a fila esta vazia
    if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);
    
   //middlewares  
   $middleware = array_shift($this->middlewares);

   //Verifica o mapeamento 
    if(!isset(self::$map[$middleware])){
      throw new \Exception("Problemas ao processar o middleware da requisição", 500);
    }
    //NEXT
    $queue = $this;

    $next = function($request) use($queue){
      return $queue->next($request);
    };
   
    //EXECUTA O Middleware
    return (new self::$map[$middleware])->handle($request,$next);

  }

}

?>