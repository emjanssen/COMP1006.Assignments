<?php
// Note: leaving detailed comments in because I find them useful for learning; would remove them from real life production code

// user class to manage user-related functions
class User
{
    // private variable to hold the database connection
    // $connection variable in user() will hold a reference to PDO connection passed from Database(), and use this reference within user() class methods
    private $connection;

    // table with which user class will interact
    private $databaseTable = 'users_assignment_two';

    /* constructor that receives a database connection, and assigns it to user class' $connection variable
    database connection is established in login.php, as per below:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $databaseConnection = (new Database())->getConnection();
        $user = new User($databaseConnection);
    */

    /* - - - Constructor - - - */

    public function __construct($databaseConnection)
    {
        // stores the passed-in database connection, i.e. $db, in the user class's private property $connection
        // inside the User object, $this->connection now holds the same PDO object returned by getConnection()
        $this->connection = $databaseConnection;
    }

    /* - - - Methods - - - */

    // check if user already exists
    // $username argument is a parameter passed in when we call userExists() elsewhere in our code
    public function userExists($username)
    {
        /* sql query to find user by username
        :username is part of PDO built-in system for named placeholders; it's a standard PDO feature
        :username isn't a variable; it's syntax to tell PDO that there's a value, and that this value will be bound later before a query is actually executed
        $this->databaseTable tells code which table to use; i.e. the $databaseTable variable we created in this class
        */
        $doesUserExistSQL = "SELECT id FROM {$this->databaseTable} WHERE username = :username";

        /* prepare SQL query to prevent SQL injection; how prepare() works/why it matters
        prepare() is a PDO method; it prepares an SQL statement for execution, instead of running query immediately
        creates a prepared statement with placeholders (for example, :username); data will be inserted later
        it allows the database to parse the SQL query structure before any actual data values are provided
        this lets us bind data values to placeholders without directly embedding user input into query; prevents malicious sql code from affecting query
        it lets us treat user input as data, instead of immediately just treating like valid code to be executed
        assigns the value of our prepared sql statement to $doesUserExistSQLStatement
        */
        $doesUserExistSQLStatement = $this->connection->prepare($doesUserExistSQL);

        // executes our prepared query, and passes in the $username parameter to the :username placeholder we were using previously
        $doesUserExistSQLStatement->execute([':username' => $username]);

        /* return true if row (i.e. row with relevant user) is found; otherwise, return false
        calls fetch() on our prepared sql statement; fetch() retrieves the next row from our query's returned result
        PDO::FETCH_ASSOC parameter tells fetch() to return row as associative array; this lets us access columns by their column names
        if there are no more rows, fetch() returns false
        !== false syntax compares result of fetch() strictly to false; if fetch() returns an array, a matching row has been found, and this expression is true
        other, expression evaluates to false
        */
        return $doesUserExistSQLStatement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function userEmailExists($email)
    {
        /* sql query to find user by email */
        $doesUserEmailExistSQL = "SELECT email_address FROM {$this->databaseTable} WHERE email_address = :email_address";

        /* prepare SQL query to prevent SQL injection */
        $doesUserEmailExistSQLStatement = $this->connection->prepare($doesUserEmailExistSQL);

        // executes our prepared query, and passes in the $email parameter to the :email placeholder we were using previously
        $doesUserEmailExistSQLStatement->execute([':email_address' => $email]);

        /* return true if row (i.e. row with relevant email) is found; otherwise, return false
        if fetch() returns an array, a matching row has been found, and this expression is true; otherwise, expression evaluates to false */
        return $doesUserEmailExistSQLStatement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function registerUser($username, $firstName, $lastName, $email, $password)
        // in-future, refactor this so it echoes a more specific error message (ex. whether username or email is already taken)
        // right now there's just a default echo output that says, 'Registration failed. Username may already exist.'
    {
        // check if username already exists; call the userExists() function to validate
        if ($this->userExists($username)) {
            // user already exists; return false
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

    /* commenting out getAllUsers() because we won't be having a dashboard page for this assignment
    keeping function for future reference

    public function getAllUsers()
    {

        // execute query to fetch all users from the table
        $getAllUsersStatement = $this->connection->query("SELECT * FROM {$this->databaseTable}");

        // return result as array of associative arrays
        return $getAllUsersStatement->fetchAll(PDO::FETCH_ASSOC);
    }*/

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

    // - - - Update User Data Functions - - - //

    // plan for future: refactor so we have one function to update a variety of user data
    // for now, start simple, and make one function for each option for user data update
    // not going to comment each function, as the process is essentially the same

    public function updateUsername($id, $username)
    {
        // SQL query to update username based on user ID
        $sqlUpdateUsername = "UPDATE {$this->databaseTable} SET username = :username WHERE id = :id";

        // Prepare the SQL query
        $sqlUpdateUsernameStatement = $this->connection->prepare($sqlUpdateUsername);

        // Execute the update with new username and ID
        return $sqlUpdateUsernameStatement->execute([':username' => $username, ':id' => $id]);
    }

    public function updateFirstName($id, $firstName)
    {
        $sqlUpdateFirstName = "UPDATE {$this->databaseTable} SET first_name = :first_name WHERE id = :id";
        $sqlUpdateFirstNameStatement = $this->connection->prepare($sqlUpdateFirstName);
        return $sqlUpdateFirstNameStatement->execute([':first_name' => $firstName, ':id' => $id]);
    }

    public function updateLastName($id, $lastName)
    {
        $sqlUpdateLastName = "UPDATE {$this->databaseTable} SET last_name = :last_name WHERE id = :id";
        $sqlUpdateLastNameStatement = $this->connection->prepare($sqlUpdateLastName);
        return $sqlUpdateLastNameStatement->execute([':last_name' => $lastName, ':id' => $id]);
    }

    public function updateEmail($id, $email)
    {
        $sqlUpdateEmail = "UPDATE {$this->databaseTable} SET email_address = :email_address WHERE id = :id";
        $sqlUpdateEmailStatement = $this->connection->prepare($sqlUpdateEmail);
        return $sqlUpdateEmailStatement->execute([':email_address' => $email, ':id' => $id]);
    }





}

?>
