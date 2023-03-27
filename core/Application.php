<?php
namespace app\core;
use app\core\db\Database;
use app\core\db\DbModel;
class Application
{
    public static string $ROOT_DIR;
    public string $layout='main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DbModel $user=NULL;
    public View $view;
    public static Application $app;
    public ?Controller $controller=null;
    public function __construct($rootPath,array $config){
        $this->userClass=$config['userClass'];
        self::$ROOT_DIR=$rootPath;
        self::$app=$this;
        $this->request=new Request();
        $this->response=new Response();
        $this->session=new Session();
        $this->router=new Router($this->request,$this->response);
        $this->db=new Database($config['db']);
        $this->view=new View();
        //$this->request=$request;
        $primaryValue=$this->session->get('user');
        if($primaryValue){            
            $newuser=new $this->userClass();
            $primaryKey=$newuser->primaryKey();
            $this->user=$newuser->findOne([$primaryKey=>$primaryValue]);
        }
    }
    public function run(){
        try{            
            echo $this->router->resolve(); 
            }catch(\Exception $e){
                $this->response->setStatusCode($e->getCode());
                echo $this->view->renderView('_error',[
                    'exception'=>$e
                ]);
            }
    }
    public function getController(){
        return $this->controller;
    }
    public function setController(){
        return $this->controller;
    }
    public function login(UserModel $user){
        $this->user=$user;
        $primaryKey=$user->primaryKey();
        $primaryValue=$user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }
    public function logout(){
        $this->user= null;
        $this->session->remove('user');
    }
    public static function isGuest(){
        return !self::$app->user;
    }
}