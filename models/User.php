<?php
namespace app\models;
use app\core;
use app\core\UserModel;

/**
 * Summary of User
 */
class User extends UserModel
{    
    const STATUS_INACTIVE=0;
    const STATUS_ACTIVE=1;
    const STATUS_DELETED=2;
    public string $firstname='';
    public string $lastname='';
    public string $email='';
    /**
     * Summary of password
     * @var string
     */
    public string $password='';
    public int $status=self::STATUS_INACTIVE;
    public string $confirmpassword='';
    public function tableName(): string
    {
        return 'users';
    }
    public function primaryKey():string
    {
        return 'id';
    }
    public function save(){
        $this->status=self::STATUS_INACTIVE;
        $this->password=password_hash($this->password,PASSWORD_DEFAULT);
        return parent::save();
    }
    public function register(){
        return $this->save();
    }
    public function rules():array{
        return[
            'firstname'=>[self::RULE_REQUIRED],
            'lastname'=>[self::RULE_REQUIRED],
            'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL,[
                self::RULE_UNIQUE,'class'=>self::class
                ]],
            'password'=>[self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8],[self::RULE_MAX,'max'=>12]],
            'confirmpassword'=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']],
        ];
    }
   public function attributes(): array
   {
        return ['firstname','lastname','email','password','status'];
   }
   public function labels(): array
   {
        return [
            'firstname'=>'First Name',
            'lastname'=>'Last Name',
            'email'=>'Your Email',
            'password'=>'Password',
            'confirmpassword'=>'Confirm Password'
        ];
   }
   public function getDisplayName():string
   {
        return $this->firstname.' '.$this->lastname;
   }
}