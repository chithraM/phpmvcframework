<?php
namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;
use app\core\middlewares\AuthMiddleware;

class AuthController extends Controller{
    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware(['profile']));
       // $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    public function login(Request $request,Response $response){
        $loginForm=new LoginForm();
        if($request->isPost())
        {
            $loginForm->loadData($request->getBody());
            if($loginForm->validate() && $loginForm->login())
            {
                $response->redirect('/');
                Application::$app->login();
                return;
            }
        }
        $this->setLayout('auth');
        return $this->render('login',[
            'model'=>$loginForm
        ]);
    }
    public function register(Request $request){
        $errors=[];
        $user=new User();
        if($request->isPost()){          
            $user->loadData($request->getBody());
           
            if($user->validate() && $user->register()){
                Application::$app->session->setFlash('success','Thanks for Registering');
                Application::$app->response->redirect('/');
            }
           
            return $this->render('register',[
                'model'=>$user
            ]);
        }
        $this->setLayout('auth');
        return $this->render('register',[
            'model'=>$user
        ]);
       /* return $this->render('register',[
            'errors'=>$errors
        ]);*/
    }
    public function logout(Request $request,Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }
    public function profile(){
        return $this->render('profile');
    }
   
}