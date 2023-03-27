<?php
namespace app\core;
use app\core\exception\ForbiddenException;
use app\core\exception\NotFoundException;
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes=[
        /*'get'=>[
            '/'=>callback,
            '/contact'
        ],
        'post'=>[

        ]*/
    ];
    public function __construct(Request $request,Response $response){
        $this->request=$request;
        $this->response=$response;
    }
    
    public function get($path,$callback){
        $this->routes['get'][$path]=$callback;
    }
    public function post($path,$callback){
        $this->routes['post'][$path]=$callback;
    }
    public function resolve(){
        $path=$this->request->getPath();
        //$method=$this->request->getMethod();
        $method=$this->request->method();
        $callback=$this->routes[$method][$path] ?? false;
        if($callback===false){
            //Application::$app->response->setStatusCode(404);
            $this->response->setStatusCode(404);
            throw new NotFoundException();
           // return $this->renderView("_404");
            //return $this->renderContent("Not Found");
           // return 'Not Found';
        }
        if(is_string($callback)){
            return Application::$app->view->renderView($callback);
        }
        if(is_array($callback)){
            $contoller=new $callback[0]();
            Application::$app->controller=$contoller;
            $contoller->action=$callback[1];            
            $callback[0]=$contoller;
            foreach($contoller->getMiddlewares() as $middleware)
            {
                $middleware->execute();
            }
            //$callback[0]=new $callback[0]();
        }
        return call_user_func($callback,$this->request,$this->response);

       /* echo '<pre>';
        var_dump($callback);
        echo '</pre>';
        exit;
        //print_R($_SERVER);*/
    }
   
}