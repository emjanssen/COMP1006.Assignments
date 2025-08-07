<?php

/* - - - Classes - - - */

// user class to manage user-related functions
class User
{
    /* - - - Variables - - - */

    // database connection
    private PDO $connection;
    // table wherein user data will be stored
    private string $tableAdmin = 'final_project_admin';
    // table wherein user content be stored
    private string $tableContent = 'final_project_content';

    /* - - - Constructor - - - */

    // receive database connection and assign to User class $connection variable
    public function __construct($databaseConnection)
    {
        $this->connection = $databaseConnection;
    }

    /* Getter */

    // so we can call the private $tableContent value in photo.php
    public function getContentTable(): string {
        return $this->tableContent;
    }

    /* - - - Methods - - - */

    // Does User Exist //

    public function userExists($username): bool
    {
        $sql = "SELECT user_id FROM {$this->tableAdmin} WHERE username = :username";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Does Email Exist //

    public function emailExists($email): bool
    {
        $sql = "SELECT email_address FROM {$this->tableAdmin} WHERE email_address = :email_address";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email_address' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Register User //

    public function registerUser($username, $password, $firstName, $lastName, $emailAddress, $phoneNumber): bool
    {
        $hash = hash('sha512', $password);
        $sql = "INSERT INTO {$this->tableAdmin} (username, password, first_name, last_name, email_address, phone_number)
            VALUES (:username, :password, :first_name, :last_name, :email_address, :phone_number)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hash,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email_address' => $emailAddress,
            ':phone_number' => $phoneNumber]);
    }

    // Create Default Content During User Registration //

    public function createDefaultContent($userID, $userTitle = '', $userBody = '') {
        $sql = "INSERT INTO {$this->tableContent} (user_id, user_title, user_body) 
            VALUES (:user_id, :user_title, :user_body)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userID,
            ':user_title' => $userTitle,
            ':user_body' => $userBody
        ]);
    }

    // Login User //

    public function loginUser($username, $password): array|false
    {
        $hash = hash('sha512', $password);
        $sql = "SELECT * FROM {$this->tableAdmin} WHERE username = :username AND password = :password";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':username' => $username, ':password' => $hash]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get All Users //

    public function getAllUsers(): array
    {
        $stmt = $this->connection->query("SELECT * FROM {$this->tableAdmin}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Find User //

    public function findUser($id): array|false
    {
        $sql = "SELECT * FROM {$this->tableAdmin} WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete User //

    public function deleteUser($id): bool
    {
        $sql = "DELETE FROM {$this->tableAdmin} WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // - Update username - //

    public function updateUsername($id, $username): bool
    {
        $sql = "UPDATE {$this->tableAdmin} SET username = :username WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':username' => $username, ':id' => $id]);
    }

    public function updateFirstName($id, $firstName): bool
    {
        $sql = "UPDATE {$this->tableAdmin} SET first_name = :first_name WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':first_name' => $firstName, ':id' => $id]);
    }

    public function updateLastName($id, $lastName): bool
    {
        $sql = "UPDATE {$this->tableAdmin} SET last_name = :last_name WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':last_name' => $lastName, ':id' => $id]);
    }

    public function updateEmail($id, $email): bool
    {
        $sql = "UPDATE {$this->tableAdmin} SET email_address = :email_address WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':email_address' => $email, ':id' => $id]);
    }

    public function updatePhoneNumber($id, $phoneNumber): bool
    {
        $sql = "UPDATE {$this->tableAdmin} SET phone_number = :phone_number WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':phone_number' => $phoneNumber, ':id' => $id]);
    }

    // - Update Content - //

    public function updateUserTitle($id, $title): bool
    {
        $sql = "UPDATE {$this->tableContent} SET user_title = :title WHERE user_id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':title' => $title, ':id' => $id]);
    }


    public function updateUserBody($id, $body): bool
    {
        $sql = "UPDATE {$this->tableContent} SET user_body = :user_body WHERE user_id = :user_id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':user_body' => $body, ':user_id' => $id]);
    }


    // Get User Content //
    public function getUserContent($userId) {
        // LIMIT 1 clause tells database to return at most one row from query result, even if more rows match condition
        $sql = "SELECT user_title, user_body FROM {$this->tableContent} WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
