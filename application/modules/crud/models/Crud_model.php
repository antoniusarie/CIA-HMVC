<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $sql;

    function __construct()
    {
        parent::__construct();
        $this->connection();
    }

    function connection()
    {
        $subject = file_get_contents(APPPATH.'config/database.php');
        $string = str_replace("defined('BASEPATH') OR exit('No direct script access allowed');", "", $subject);

        $con = 'connection.php';
        $create = fopen($con, "w") or die("Change your permision folder for application and folder to 777");
        fwrite($create, $string);
        fclose($create);

        require $con;

        $this->host = $db['default']['hostname'];
        $this->user = $db['default']['username'];
        $this->password = $db['default']['password'];
        $this->database = $db['default']['database'];

        $this->sql = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->sql->connect_error)
        {
            echo $this->sql->connect_error . ", please check 'application/config/database.php'.";
            die();
        }

        unlink($con);
    }

    function list_tables()
    {
        $all_tables = $this->db->list_tables();
        $disallow_tables = array("users", "users_groups", "groups", "menu", "login_attempts"); // exclude tables as Array
        $tables = array_diff($all_tables, $disallow_tables);
        return $tables;
    }

    function primary_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_KEY = 'PRI'";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key);
        $stmt->execute();
        $stmt->fetch();
        return $column_name;
        $stmt->close();
        $this->sql->close();
    }

    function not_primary_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_KEY <> 'PRI'";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key, $data_type);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[] = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

    function all_field($table)
    {
        $query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=? AND TABLE_NAME=?";
        $stmt = $this->sql->prepare($query) OR die("Error code :" . $this->sql->errno . " (not_primary_field)");
        $stmt->bind_param('ss', $this->database, $table);
        $stmt->bind_result($column_name, $column_key, $data_type);
        $stmt->execute();
        while ($stmt->fetch()) {
            $fields[] = array('column_name' => $column_name, 'column_key' => $column_key, 'data_type' => $data_type);
        }
        return $fields;
        $stmt->close();
        $this->sql->close();
    }

}
