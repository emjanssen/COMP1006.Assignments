<?php

/* - - - Classes - - - */

// user class to manage user-related functions
class User
{
    /* - - - Variables - - - */

    // database connection
    private PDO $connection;
    // table wherein data will strored
    private string $databaseTable = 'users_final_project';

    /* - - - Constructor - - - */

    // receive database connection and assign to User class $connection variable
    public function __construct($databaseConnection)
    {
        $this->connection = $databaseConnection;
    }

    /* - - - Methods - - - */

    // Does User Exist //

    public function userExists(string $username): bool
    {
        $sql = "SELECT id FROM {$this->databaseTable} WHERE username = :username";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Does Email Exist //

    public function emailExists(string $email): bool
    {
        $sql = "SELECT email_address FROM {$this->databaseTable} WHERE email_address = :email_address";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email_address' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Register User //

    public function registerUser($username, $password, $firstName, $lastName, $emailAddress, $phoneNumber, $photo): bool
    {
        $hash = hash('sha512', $password);
        $sql = "INSERT INTO {$this->databaseTable} (username, password, first_name, last_name, email_address, phone_number, photo)
            VALUES (:username, :password, :first_name, :last_name, :email_address, :phone_number, :photo)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hash,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email_address' => $emailAddress,
            ':phone_number' => $phoneNumber,
            ':photo' => $photo
        ]);
    }

    // Login User //

    public function loginUser($username, $password)
    {
        $hash = hash('sha512', $password);
        $sql = "SELECT * FROM {$this->databaseTable} WHERE username = :username AND password = :password";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':username' => $username, ':password' => $hash]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get All Users //

    public function getAllUsers()
    {
        $stmt = $this->connection->query("SELECT * FROM {$this->databaseTable}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find User //

    public function findUser($id)
    {
        $sql = "SELECT * FROM {$this->databaseTable} WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete User //

    public function deleteUser($id): bool
    {
        $sql = "DELETE FROM {$this->databaseTable} WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
