<?php
namespace day7\UserSystemBundle\Connection;


class Sql{

    private static $instance=null;

    private function ConnectUser()
    {
        /*$sqlini=  parse_ini_file("databaseConfig.ini");
        $dbms=$sqlini[database_driver];     //数据库类型
        $host=$sqlini[database_host]; //数据库主机名
        $dbName=$sqlini[database_name];  //使用的数据库
        $user=$sqlini[database_user];     //数据库连接用户名
        $pass=$sqlini[database_password];         //对应的密码*/
        $dbms='mysql';     //数据库类型
        $host='localhost'; //数据库主机名
        $dbName='user-manage-system';  //使用的数据库
        $user='root';     //数据库连接用户名
        $pass='root';         //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        try {
        $dbh = new \PDO($dsn, $user, $pass, array(\PDO::ATTR_PERSISTENT => true))//初始化一个PDO对象
        or die("链接错误");
        $dbh->query("SET NAMES utf8");
        } catch (\PDOException $e) {
        die ("Error!: " . $e->getMessage() . "<br/>");
        }
        return $dbh;
    }

    private function __construct(){}

    public static function connect(){
    if (is_null ( self::$instance ) || empty(  self::$instance )) {
    self::$instance = new self();
    return self::$instance->ConnectUser();
    }
    return self::$instance->ConnectUser();
    }


}
?>