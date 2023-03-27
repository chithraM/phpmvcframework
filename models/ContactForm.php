<?php
namespace app\models;
use app\core\Application;
use app\core\Model;

/**
 * Summary of LoginForm
 */
class ContactForm extends Model
{
    public string $subject='';
    public string $email='';
    public string $body='';
    public function rules():array
    {
       return [
            'subject'=>[self::RULE_REQUIRED],
            'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL],
            'body'=>[self::RULE_REQUIRED]
       ];
    }
    public function labels():array
    {
        return[
            'subject'=>'Enter your Subject',
            'email'=>'Your Email',
            'body'=>'Body'
        ];
    }
    /**
     * Summary of login
     * @return bool
     */
    public  function send(){
       return true;
    }
}