<?php

namespace Core;

use Config\Database;
use mysqli;

class Model {
    private $_connection;
    private static $_instance;

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {
        if(!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {

        $this->_connection = new mysqli(Database::DB_HOST, Database::DB_USER,
            Database::DB_PASSWORD, Database::DB_NAME);


        if(mysqli_connect_error()) {
            trigger_error("Failed to connect to MySQL: " . mysql_connect_error(),
                E_USER_ERROR);
        }
    }


    public function insert($table_name, $data) {
        // Fields to be added.
        $fields = array_keys($data);
        // Fields values
        $values = array_values($data);

        $stmt = "INSERT INTO " . $table_name . " (" . implode(",", $fields) . ") VALUES('" . implode("','", $values) . "')";
        if(mysqli_query($this->_connection, $stmt)){
            return mysqli_insert_id($this->_connection);
        }else{
            return mysqli_error($this->_connection);
        }
    }

    public function getConnection() {
        return $this->_connection;
    }
}
