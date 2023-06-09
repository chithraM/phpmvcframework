<?php
namespace app\core\db;
use app\migrations;
use PDO;

/**
 * Summary of Database
 */
class Database{
    public PDO $pdo;
    public function __construct(array $config){
        $dsn=$config['dsn'] ?? '';
        $user=$config['user'] ?? '';
        $password=$config['password'] ?? '';
        $dsn=$config['dsn'] ?? '';
        $this->pdo=new PDO($dsn,$user,$password);
       $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    /**
     * Summary of applyMigrations
     * @return void
     */
    public function applyMigrations(){
        $this->createMigrationsTable();
       $appliedMigrations=$this->getAppliedMigrations();

        $newmigrations=[];
        $files=scandir(Application::$ROOT_DIR.'/migrations');
        $toApplyMigrations=array_diff($files,$appliedMigrations);
       foreach($toApplyMigrations as $migration){
        if($migration==='.'||$migration==='..'){
            continue;
        }
        require_once Application::$ROOT_DIR.'/migrations/'.$migration;
        $className=pathinfo($migration,PATHINFO_FILENAME);        
        $instance=new $className();
        $this->log("Applying Migration $migration");
        $instance->up();
        $this->log("Applied Migration $migration");
        $newmigrations[]=$migration;
       }
       if(!empty($newmigrations)){
            $this->saveMigrations($newmigrations);
       }
       else{
            $this->log("All migrations are applied");
       }
    }
    /**
     * Summary of createMigrationsTable
     * @return void
     */
    public function createMigrationsTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
            ENGINE=INNODB;");

    }
    
    /*
     * Summary of getAppliedMigrations
     * @return void
     */
    public function getAppliedMigrations(){
       $statement=$this->pdo->prepare("SELECT migration FROM migrations");
       $statement->execute();
       return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
    
     /* Summary of saveMigrations
     * @param array $migrations
     * @return void
     */
    public function saveMigrations(array $migrations){
       $str=implode(",",array_map(fn($m)=>"('$m')",$migrations));
        $statement=$this->pdo->prepare("INSERT INTO migrations(migration) VALUES $str");
        $statement->execute();
    }
    public function prepare($sql){
        return $this->pdo->prepare($sql);
    }
    protected function log($message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
}