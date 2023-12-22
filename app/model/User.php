<?php

namespace App\Model;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Database\Database;
use PDO;
class User {
    protected $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function createUser($fullname, $email, $password, $phone, $roleId = 2) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            INSERT INTO User (fullname, email, password, phone, role_id) 
            VALUES (:fullname, :email, :hashedPassword, :phone, :roleId)
        ");
    
        // Bind parameters to statement variables
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':hashedPassword', $hashedPassword);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':roleId', $roleId);
    
        // Execute the statement and check for success
        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
    
        return false;
    }
    
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, fullname, email, phone, role_id FROM User");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inside User.php

    public function deleteUser($userId) {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();
    }

    public function getUserById($userId) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($userId, $fullname, $email, $phone, $role) {
        $stmt = $this->db->prepare("
            UPDATE user
            SET fullname = :fullname, email = :email, phone = :phone,role_id= :role
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
        return $stmt->execute();
    }


    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
