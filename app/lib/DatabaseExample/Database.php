<?php

/**
* Database Class
*
* The Database class handles the database connection used throughout the application.
*/

namespace DatabaseExample;

use PDO;

class Database {

    private $host = "localhost";
    private $database = "mock_db";
    private $username = "root";
    private $password = "";

    public $connection;


    /**
     * Database Constructor
     *
     * Creates a new PDO connection object and connects to database.
     */
    public function __construct() {

        /*
        Create new PDO connection object and connect to the database.
        */
        $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);

    }

    /**
     * Database Close Method
     *
     * Destroys the PDO connection object and closes the process connection to the database.
     *
     * @return void
     */
    public function close() {

        $this->connection = null;

    }


}
