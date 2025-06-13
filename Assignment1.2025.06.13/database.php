<?php

// purpose: database connection
class database
{
    private $host = 'YourHostIP';
    private $user = 'YourUsername';
    private $password = 'YourPassword';
    private $database = 'YourDatabaseName';
    protected $connection;

    // protected variable to store our connection

    public function __construct()
    {
        if (!isset($this->connection)) {
            // if our connection hasn't been set yet
            $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
            // create a new connection to the mysql server and assign the parameter names
        } else {
            echo "We are already connected to the database";
        }
    }
}