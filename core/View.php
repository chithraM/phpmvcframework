<?php
namespace app\core;
class View
{
    public string $title='';
    public function renderView($view,$params=[]){
        $layoutContent=$this->layoutContent();
        $viewContent=$this->renderOnlyView($view,$params);
        return str_replace('{{content}}',$viewContent,$layoutContent);
        //include_once __DIR__."/../views/$view.php";

    }
    public function renderContent($viewContent){
        $layoutContent=$this->layoutContent();
        return str_replace('{{content}}',$viewContent,$layoutContent);

    }
    protected function layoutContent(){
        $layout=Application::$app->layout;
        if(Application::$app->controller)
        {
            $layout=Application::$app->controller->layout;
        }
        ob_start();
        //include_once Application::$ROOT_DIR."/views/layouts/main.php";        
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view,$params){
        foreach($params as $key=>$value){
            $$key=$value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}