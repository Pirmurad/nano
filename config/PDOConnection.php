<?php
class PDOConnection
{
    protected static $_instance = null;

    public static function instance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new PDOConnection();
        }
        return self::$_instance;
    }

    protected function __construct(){}
    function __destruct(){}

    public function getConnection($dsn, $username, $password)
    {
        $conn = null;
        try {
            $conn = new \PDO($dsn, $username, $password);

            //Set common attributes
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            $conn->exec("SET NAMES utf8");

            return $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        } catch (Exception $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function __clone(){return false;}
    public function __wakeup(){return false;}
}
