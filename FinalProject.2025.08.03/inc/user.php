<?php

/* - - - Classes - - - */

// user class to manage user-related functions
class User
{
    /* - - - Variables - - - */

    // private variable to hold the database connection
    private $connection;
    // table with which user class will interact
    private $databaseTable = 'users_final_project';

    /* - - - Constructor - - - */

    // constructor receives a database connection, and assigns it to user class' $connection variable
    public function __construct($databaseConnection)
    {
        // stores the passed-in database connection
        $this->connection = $databaseConnection;
    }

    /* - - - Methods - - - */

    // check if user already exists
    public function userExists($username)
    {
        // sql query to find user by username
        $doesUserExistSQL = "SELECT id FROM {$this->databaseTable} WHERE username = :username";
        // prepare SQL query to prevent SQL injection
        $doesUserExistSQLStatement = $this->connection->prepare($doesUserExistSQL);
        // executes our prepared query, and passes in the $username parameter to the :username placeholder we were using previously
        $doesUserExistSQLStatement->execute([':username' => $username]);
        // return true if row (i.e. row with relevant user) is found; otherwise, return false
        return $doesUserExistSQLStatement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function userEmailExists($email)
    {
        // sql query to find user by email
        $doesUserEmailExistSQL = "SELECT email_address FROM {$this->databaseTable} WHERE email_address = :email_address";
        // prepare SQL query to prevent SQL injection
        $doesUserEmailExistSQLStatement = $this->connection->prepare($doesUserEmailExistSQL);
        // executes our prepared query, and passes in the $email parameter to the :email placeholder we were using previously
        $doesUserEmailExistSQLStatement->execute([':email_address' => $email]);
        // return true if row (i.e. row with relevant email) is found; otherwise, return false
        return $doesUserEmailExistSQLStatement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function registerUser($username, $firstName, $lastName, $email, $password)
    {
        // check if username already exists; call the userExists() function to validate
        if ($this->userExists($username)) {
            // if user already exists, return false
            return false;
        }

        // check if email already exists; call the userEmailExists() function to validate
        if ($this->userEmailExists($email)) {
            // if email already exists, return false
            return false;
        }

        // hash password using SHA-512
        $hash = hash('sha512', $password);
        // sql query to insert new user into table
        $sqlInsertNewUser = "INSERT INTO {$this->databaseTable} (username, first_name, last_name, email_address, password)
            VALUES (:username, :first_name, :last_name, :email_address, :password)";
        // prepare insert query
        $sqlInsertNewUserStatement = $this->connection->prepare($sqlInsertNewUser);
        // execute query with username and hashed password
        // return the result of execute(); if the insert fails, false is returned
        return $sqlInsertNewUserStatement->execute([
            ':username' => $username,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email_address' => $email,
            ':password' => $hash,
        ]);
    }

    public function loginUser($username, $password)
    {
        // hash password using SHA-512 for comparison
        $hash = hash('sha512', $password);
        // SQL query to select user that matches the provided credentials
        $sqlSelectUserForLogin = "SELECT * FROM {$this->databaseTable} WHERE username = :username AND password = :password";
        // prepare SQL query
        $sqlSelectUserForLoginStatement = $this->connection->prepare($sqlSelectUserForLogin);
        // execute query with username and hashed password
        $sqlSelectUserForLoginStatement->execute([':username' => $username, ':password' => $hash]);
        // fetch and return user data if credentials are correct; return false if not
        return $sqlSelectUserForLoginStatement->fetch(PDO::FETCH_ASSOC);
    }

    // return all users from the table
    public function getAllUsers()
    {
        // execute query to fetch all users from the table
        $getAllUsersStatement = $this->connection->query("SELECT * FROM {$this->databaseTable}");
        // return result as array of associative arrays
        return $getAllUsersStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUser($id)
    {
        // SQL query to fetch user data by ID
        $sqlFindUser = "SELECT * FROM {$this->databaseTable} WHERE id = :id";
        // prepare SQL query
        $sqlFindUserStatement = $this->connection->prepare($sqlFindUser);
        // execute query using the passed-in ID parameter
        $sqlFindUserStatement->execute([':id' => $id]);
        // fetch and return user data
        return $sqlFindUserStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id)
    {
        // SQL query to delete user by ID
        $sqlDeleteUserByID = "DELETE FROM {$this->databaseTable} WHERE id = :id";
        // Prepare the SQL query
        $sqlDeleteUserByIDStatement = $this->connection->prepare($sqlDeleteUserByID);
        // Execute the deletion using the given ID
        return $sqlDeleteUserByIDStatement->execute([':id' => $id]);
    }
}

