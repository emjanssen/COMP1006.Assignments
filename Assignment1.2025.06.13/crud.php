<?php
require_once "database.php";
// purpose: functions to interact with the database

class crud extends database
{
    public function __construct()
    {
        // creates constructor method for crud class
        parent::__construct();
        // calls database constructor
        // ensures that when we create a crud object, the code executed by database constructor is also executed
    }

    public function getData($query)
    {
        // creates new function that takes one argument
        $result = $this->connection->query($query);
        // using built-in query function
        // $this->connection is from database.php
        // executes query on this instance of connection
        // $result holds the info returned by the SQL database query; i.e. it holds all the rows that match the query

        if ($result == false) {
            // if the query failed, return false
            return false;
        }
        $rows = array();
        // creates an empty array named $rows
        while ($row = $result->fetch_assoc()) {
            // uses built-in $result->fetch_assoc() method
            // this function fetches the next row from the result set (as an associative array)
            // associative array: keys are column names, values are corresponding data for that row
            // while loop stops once there are no more rows to fetch
            $rows[] = $row;
            // appends the current $row associative array to the $rows array
        }
        // return the final value of $rows array
        return $rows;
    }

    public function execute($query)
    {
        // creates function that takes one argument
        $result = $this->connection->query($query);
        // executes query on this instance of connection using $query value
        // stores result in $result
        if ($result == false) {
            // if query fails, return false
            return false;
        } else {
            // if connection doesn't fail, return true
            return true;
        }
    }

    public function escape_string($value)
    {
        // creates new function that takes on value
        return $this->connection->real_escape_string($value);
        // real_escape_string() is a built-in function
        // it escapes (i.e. adds backslashes to) special characters so they are safe for sql queries
    }
}

?>
