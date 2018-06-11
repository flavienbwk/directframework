<?php

/**
 * A useful class to directly connect and use your database.
 */
class databaseModel {

    private $_db_type = "pgsql"; // mysql|psql ...
    private $_db_password = "your_db_password";
    private $_db_name = "your_db_name";
    private $_db_user = "your_db_user";
    private $_db_host = "localhost";
    private $_db_port = "5432";
    private $_database = false;
    private $_connected = false;
    private $_message = "";

    public function __construct() {
        // Connect to the database.
        try {
            $database = new PDO($this->_db_type . ':host=' . $this->_db_host . ':' . $this->_db_port . ';dbname=' . $this->_db_name, $this->_db_user, $this->_db_password);
            $this->_database = $database;
        } catch (PDOException $e) {
            $this->_message = "Error ! (" . $e->getMessage() . ")<br/>";
        }

        if (!$this->_database) {
            $this->_message = "Error while connecting to the database.";
            $this->_connected = false;
        } else {
            $this->_message = "Successfuly connected.";
            $this->_connected = true;
        }
        return $this->_connected;
    }

    public function getDatabase() {
        return $this->_database;
    }

    protected function getMessage() {
        return $this->_message;
    }

    protected function isConnected() {
        return ($this->_connected);
    }

    /**
     * Insert a new row in the database.
     *
     * @param string $table Name of the table to insert a new row.
     * @param array $data Associative array. Key names are field names.
     * @return boolean|array False if an error occured.
     */
    protected function insert($table, $data) {
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

    /**
     * Select a row in the database.
     *
     * @param string $table Name of the table to select a row.
     * @param array $data Associative array. Key names are field names.
     * @return boolean|array False if no result.
     */
    protected function select($table, $data) {
        $this->_database->exec('SET SCHEMA public'); // Only for PSQL.
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
        $query = $this->_database->prepare("SELECT * FROM \"" . $table . "\"" . $parameters);
        $query->execute();
        if ($query->rowCount()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /**
     * Select one or multiple rows in the database.
     *
     * @param string $table Name of the table to select the rows.
     * @param array $data Associative array. Key names are field names.
     * @return boolean|array False if no result.
     */
    protected function selectAll($table, $data, $date_desc = false, $limit_l = false, $limit_r = false) {
        $this->_database->exec('SET SCHEMA public');  // Only for PSQL.
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

    /**
     * Update one or multiple rows in the database.
     *
     * @param string $table Name of the table to update the row(s).
     * @param array $data Associative array. Key names are field names.
     * @param array $where Associative array. Key names are field names and there values are the values to update.
     * @return boolean|array False if no result.
     */
    protected function update($table, $data, $where) {
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
