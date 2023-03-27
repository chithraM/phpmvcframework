<?php 
namespace app\core\form;
use app\core\Model;
/**
 * Summary of Form
 */
class Form{
    /**
     * Summary of begin
     * @param mixed $action
     * @param mixed $method
     * @return Form
     */
    public static function begin($action,$method){
        echo sprintf('<form action="%s" method="%s">',$action,$method);
        return new Form();
    }
    public static function end(){
        echo '</form>';
    }
    public function field(Model $model,$attribute){
        return new InputField($model,$attribute);
    }
}