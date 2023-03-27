<?php
namespace app\core\db;
use app\core\Application;
use app\core\Model;

/**
 * Summary of DbModel
 */
abstract class DbModel extends Model{    
    /**
     * Summary of tableName
     * @return string
     */
    abstract public function tableName():string;

    /**
     * Summary of attributes
     * @return array
     */
    abstract public function attributes():array;
    abstract public function primaryKey():string;
    /**
     * Summary of save
     * @return bool
     */
    public function save(){
        $tableName =$this->tableName();
        $attributes=$this->attributes();
        $params=array_map(fn($attr)=>":$attr",$attributes);
        $statement=self::prepare("INSERT INTO $tableName (".implode(',',$attributes).") 
            VALUES(".implode(',',$params).")");
        foreach($attributes as $attribute){
            $statement->bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return true;
    }
    /**
     * Summary of findOne
     * @param mixed $where
     * @return bool|object
     */
    public function findOne($where){
        $tableName= static::tableName();
        $attributes=array_keys($where);
        $sql=implode("AND ",array_map(fn($attr)=>"$attr =:$attr",$attributes));
        $statement=self::prepare("select * from $tableName where $sql");
        foreach($where as $key=>$item){
            $statement->bindValue(":$key",$item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
    /**
     * Summary of prepare
     * @return \PDOStatement|bool
     */
    public static function prepare($sql){
      return Application::$app->db->pdo->prepare($sql);
    }
    /**
     * Summary of rules
     * @return array
     */
    public function rules():array{
        return[
            'firstname'=>[self::RULE_REQUIRED],
            'lastname'=>[self::RULE_REQUIRED],
            'email'=>[self::RULE_REQUIRED,self::RULE_EMAIL],
            'password'=>[self::RULE_REQUIRED,[self::RULE_MIN,'min'=>8],[self::RULE_MAX,'max'=>12]],
            'confirmpassword'=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']],
        ];
    }
   
}