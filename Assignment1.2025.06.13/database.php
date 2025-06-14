<?php

// purpose: database connection
class Database
{
    private $host = 'YourHostIPAddress';
    private $user = 'YourUsername';
    private $password = 'YourPassword';
    private $database = 'YourDatabaseName';
    protected $connection;
    // protected variable to store our connection
    // can be accessed in this class and any subclasses

    public function __construct()
        // declare constructor for Database class
    {
        if (!isset($this->connection)) {
            // if our connection hasn't been set yet
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
            // create a mysql server connection when a Database object is instantiated
            // passes in values to mysqli parameters and assigns to this instance's $connection property
        } else {
            echo "We are already connected to the database";
            // if connection already exists, send message to confirm we're connected
        }
    }
}