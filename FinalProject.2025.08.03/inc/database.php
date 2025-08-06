<?php

/* - - - Classes - - - */

// database class to manage the database connection
class Database
{
    /* - - - Variables - - - */

    // private variables for database login credentials
    private $host = "";
    private $databaseName = "";
    private $username = "";
    private $password = "";

    // public variable to hold our database connection once connection has been established
    public $connection;

    /* - - - Methods - - - */

    // function for connecting to the database
    public function getDatabaseConnection()
    {
        try {
            // create new PDO object using host, database name, username, and password
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->databaseName, $this->username, $this->password);

            // set PDO error mode to throw exceptions
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // return our connection object
            return $this->connection;

            // if the connection fails, catch the exception and write exception details to an error log
            // for this assignment, going to try to learn how to create an error log, instead of printing the error details to an echo message
            // error_log() is a built-in PHP function; default settings are controlled via php.ini
            // can pass in three arguments: error message, append attribute, and file path to error log
            // generally going to use interpolation instead of concatenation for this assignment
        } catch (PDOException $exception) {
            error_log(
                "DB connection error: {$exception->getMessage()}", 3, '../errors/error_log');
            // echo a more generic message for the user
            die("Sorry, we were unable to process your request.");
        }
    }
}