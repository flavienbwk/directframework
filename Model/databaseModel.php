<?php

/**
 * A really, really useful class allowing you to call
 * easily your database with simple methods.
 *
 * Declare it that way : $databaseModel = new databaseModel();
 */
class databaseModel {

    private $_db_name = "mydb";
    private $_db_user = "root";
    private $_db_password = "toor";
    private $_db_host = "localhost";
    private $_db_port = "3306";

    private $_database = false;
    private $_connected = false;
    private $_message = "";

    public function __construct() {
        try {
            $database = new PDO('mysql:host=' . $this->_db_host . ':' . $this->_db_port . ';dbname=' . $this->_db_name, $this->_db_user, $this->_db_password);
            $this->_database = $database;
        } catch (PDOException $e) {
            $this->_message = "Error ! (" . $e->getMessage() . ")";
            $this->_connected = false;
        }

        if (!$this->_database) {
            $this->_connected = false;
        } else {
            $this->_message = "Successfuly connected.";
            $this->_connected = true;
        }
        return $this->_connected;
    }

    /**
     * Call this method to get the PDO instance of your database
     * and make custom queries.
     */
    public function getDatabase() {
        return $this->_database;
    }

    public function getMessage() {
        return $this->_message;
    }

    public function isConnected() {
        return ($this->_connected);
    }

    /**
     * Insert a new line in the database.
     *
     * @param string $table
     *            Name of the table to insert a new line
     * @param array $data
     *            Associative array. Key names are field names.
     * @return boolean
     */
    public function insert($table, $data) {
        $i = 1;
        $parameters_formated = "";
        $parameters_name = "";
        foreach ($data as $name => $val) {
            $parameters_formated .= ($i == sizeof($data)) ? ":" . $name : ":" . $name . ",";
            $parameters_name .= ($i == sizeof($data)) ? "\"" . $name . "\"" : "\"" . $name . "\",";
            $i ++;
        }
        $query_str = "INSERT INTO \"" . $table . "\" (" . $parameters_name . ") VALUES (" . $parameters_formated . ")";
        $query = $this->_database->prepare($query_str);
        $query->execute($data);
        return $query->rowCount();
    }

    public function select($table, $data = "", $date_desc = false) {
        $parameters = " WHERE";
        $counter = 0;
        foreach ($data as $item => $value) {
            if (!$counter)
                $parameters .= " \"" . $item . "\"='" . $value . "'";
            else
                $parameters .= " AND \"" . $item . "\"='" . $value . "'";
            $counter ++;
        }

        $parameters = ($data) ? $parameters : "";
        $date_desc_str = ($date_desc) ? " ORDER BY date DESC" : "";
        $query_str = "SELECT * FROM \"" . $table . "\"" . $parameters . $date_desc_str;

        $query = $this->_database->prepare($query_str);
        $query->execute();

        if ($query->rowCount()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function selectAll($table, $data, $date_desc = false, $limit_l = false, $limit_r = false) {
        $parameters = " WHERE";
        $counter = 0;
        foreach ($data as $item => $value) {
            if (!$counter)
                $parameters .= " \"" . $item . "\"='" . $value . "'";
            else
                $parameters .= " AND \"" . $item . "\"='" . $value . "'";
            $counter ++;
        }

        $parameters = ($data) ? $parameters : "";
        $date_desc_str = ($date_desc) ? " ORDER BY date DESC" : "";
        $limit_l = ($limit_l) ? " LIMIT " . $limit_l : "";
        $limit_r = ($limit_r) ? " OFFSET " . $limit_r : "";
        $query_str = "SELECT * FROM \"" . $table . "\"" . $parameters . $date_desc_str . $limit_l . $limit_r;
        $query = $this->_database->prepare($query_str);
        $query->execute();
        if ($query->rowCount()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update($table, $data, $where) {
        $i = 1;
        $parameters_formated = "";
        $where_str = "";

        foreach ($data as $name => $val) {
            $parameters_formated .= ($i == sizeof($data)) ? "\"" . $name . "\"=:" . $name : "\"" . $name . "\"=:" . $name . ",";
            $i ++;
        }

        if ($where) {
            $counter = 0;
            $where_str = " WHERE ";
            foreach ($where as $item => $value) {
                if (!$counter)
                    $where_str .= " \"" . $item . "\"='" . $value . "'";
                else
                    $where_str .= " AND \"" . $item . "\"='" . $value . "'";
                $counter ++;
            }
        }

        $query_str = "UPDATE \"" . $table . "\" SET " . $parameters_formated . $where_str;
        $query = $this->_database->prepare($query_str);
        $query->execute($data);
        return $query;
    }

}

?>
