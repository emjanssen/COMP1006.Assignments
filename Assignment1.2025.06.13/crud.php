<?php
// Include the database connection class
require_once "database.php";

// Define a class named 'crud' that extends the 'database' class
class crud extends database {

    // Constructor: Automatically called when an object is created
    public function __construct() {
        // Call the parent constructor to establish a database connection
        parent::__construct();
    }

    // Method to retrieve data from the database
    public function getData($query) {
        // Execute the provided SQL query
        $result = $this->connection->query($query);

        // If the query fails, return false
        if ($result == false) {
            return false;
        }

        // Initialize an array to store the rows of the result set
        $rows = array();

        // Fetch each row as an associative array and add it to $rows
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Return the array of rows
        return $rows;
    }

    // Method to execute a query that does not return data (e.g., INSERT, UPDATE, DELETE)
    public function execute($query) {
        // Run the provided SQL query
        $result = $this->connection->query($query);

        // Return false if the query fails
        if ($result == false) {
            return false;
        } else {
            // Return true if the query succeeds
            return true;
        }
    }

    // Method to safely escape a string for use in a SQL query
    public function escape_string($value) {
        // Return the escaped version of the input value
        return $this->connection->real_escape_string($value);
    }
}
?>
