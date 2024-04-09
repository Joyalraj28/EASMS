<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection{

    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    
    public $conn;
    
    public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
        
    }


    public static function debuglog($message)
    {
        $myfile = fopen("../Debug/Log.txt", "a") or die("Unable to open file!");

        fwrite($myfile, $message."\n");

        fclose($myfile);
    }

    public static function debugtaglog($head,$message)
    {
        $myfile = fopen("../Debug/Log.txt", "a") or die("Unable to open file!");
        fwrite($myfile, "<".$head.">\n".$message."\n<\\".$head.">\n");
        fclose($myfile);
    }

    public static function consolelog($obj)
    {
      echo "<script>console.log($obj);</script>";
    }



    public static function Iset($value,$NA)
    {
        if(isset($value))
        {
            return $value;
        }
        else
        {
            return $NA;
        }
    }

    public function __destruct(){
        $this->conn->close();
    }
}
?>