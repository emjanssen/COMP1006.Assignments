<?php

// database class to manage the database connection
class Database
{
    // private variables for host, database name, username, and password (i.e. database login in credentials)
    // do not upload actual login details to public repo
    private $host = "";
    private $databaseName = "";
    private $username = "";
    private $password = "";

    // public variable to hold our database connection once connection has been established
    public $connection;

    public function getDatabaseConnection()
    {
        try {
            /*
            create new PDO object using host, database name, username, and password
            PDO (PHP Data Objects) is a database access layer; it's provided by PHP, and it offers an interface for working with databases
            new PDO() creates a new instance of this PDO class;
            PDO takes three main arguments:
                1. DSN (Data Source Name): a string that tells PDO how to connect ("mysql:host=" . $this->host . ";dbname=" . $this->databaseName)
                    mysql: – this lets PDO know that we're connection to a MySQL database
                    host= – hostname of the database server
                    dbname= name of the database we wish to connect to
                2. the MySQL username we use to connect ($this->username)
                3. the password we use to connect ($this->password)
            */
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->databaseName, $this->username, $this->password);

            /* set PDO error mode to throw exceptions
            setAttribute() is used to configure how PDO behaves
            PDO::ATTR_ERRMODE is a built-in constant to represent the error mode attribute; it tells PHP how to behave when we encounter an error
            PDO::ERRMODE_EXCEPTION is also a built-in constant; it's the value we assign to the error mode; it tells our PDO object to throw exception when a database error occurs
            */
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // return our connection object
            return $this->connection;

            // PDOException is a built-in exception class; it represents errors related to PDO operations
        } catch (PDOException $exception) {
            // if the connection fails, catch the exception and display the error message
            // getMessage() is a built-in function in the Exception; PDOException extends Exception class, so it inherits getMessage()
            echo "Connection failed: " . $exception->getMessage();
        }
    }
}

?>