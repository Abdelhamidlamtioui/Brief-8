<?php
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Database\Database;
use App\Model\User;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function signUp($formData) {
        $fullname = filter_var($formData['fullname'], FILTER_SANITIZE_STRING);
        $email = filter_var($formData['email'], FILTER_SANITIZE_EMAIL);
        $phone = filter_var($formData['number'], FILTER_SANITIZE_NUMBER_INT);
        $password = $formData['password'];
    
        $errors = $this->validateSignUp($fullname, $email, $phone, $password);
    
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ../../view/index.php#signupModal');
            exit;
        }elseif ($this->userModel->getUserByEmail($email)!= false) {
            $_SESSION['errors'] ='User with this email already exists.';
            header('Location: ../../view/index.php#signupModal');
            exit;
        }else {
            $userId = $this->userModel->createUser($fullname, $email, $password, $phone);
            $_SESSION['success'] = 'Registration successful. Please log in.';
            header('Location: ../../view/index.php#loginModal'); 
            exit;
        }
    }
    
    private function validateSignUp($fullname, $email, $phone, $password) {
        $errors='';
        if (empty($fullname)) {
            $errors= 'Full name is required.';
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors= 'Invalid email format.';
        }elseif (empty($phone) || !preg_match('/^[0-9]{10}$/', $phone)) {
            $errors= 'Valid phone number is required.';
        }elseif (empty($password) || strlen($password) < 6) {
            $errors= 'Password must be at least 6 characters.';
        }
        return $errors; 
    }

    public function login($email, $password) {
        $user = $this->userModel->getUserByEmail($email);
        
        if ($user) {
            var_dump($user);
            echo $password;
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['is_logged_in'] = true;
                $_SESSION['success-login'] = 'You have successfully logged in.';
                header('Location: ../../view/index.php');
            } else {
                $_SESSION['errors'] = 'The password you entered is incorrect.';
                header('Location: ../../view/index.php#loginModal');
            }
        } else {
            $_SESSION['errors'] = 'No user found with that email address.';
            header('Location: ../../view/index.php#loginModal');
        }
        exit;
    }

    public function addUser($formData) {
    $fullname = filter_var($formData['fullname'], FILTER_SANITIZE_STRING);
    $email = filter_var($formData['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($formData['phone'], FILTER_SANITIZE_NUMBER_INT);
    $password = $formData['password'];
    $roleId = $formData['role']=== 'admin' ? 2 : 1;
    echo $roleId;
    if ($this->userModel->getUserByEmail($email)) {
        $_SESSION['errors'] = 'User with this email already exists.';
        header('Location: ../../view/dashboard.php');
        exit;
    }

    $userId = $this->userModel->createUser($fullname, $email, $password, $phone, $roleId);
    
    if ($userId) {
        $_SESSION['success'] = "User with ID {$userId} added successfully.";
        header('Location: ../../view/dashboard.php');
    } else {
        $_SESSION['errors'] = 'Error adding user.';
        header('Location: ../../view/dashboard.php');
    }
    exit;
    }


    public function displayUsers() {
        $users = $this->userModel->getAllUsers();
        return $users;
    }

    public function deleteUserById($userId) {
        if ($this->userModel->deleteUser($userId)) {
            $this->userModel->deleteUser($userId);
            echo $userId;
            echo "khasser";
            $_SESSION['success'] = "User deleted successfully.";
            header('Location: ../../view/dashboard.php');
        } else {
            echo "khasser";
            $_SESSION['errors'] = "User deletion failed.";
        }
        exit;
    }
    
    public function getUserDetails($userId) {
        return $this->userModel->getUserById($userId);
    }

    public function updateUser($formData) {
        $userId = $formData['user_id'];
        $fullname = filter_var($formData['fullname'], FILTER_SANITIZE_STRING);
        $email = filter_var($formData['email'], FILTER_SANITIZE_EMAIL);
        $phone = filter_var($formData['phone'], FILTER_SANITIZE_NUMBER_INT);
        $role = filter_var($formData['role'], FILTER_SANITIZE_NUMBER_INT);

        $result = $this->userModel->updateUser($userId, $fullname, $email, $phone,$role);

        if ($result) {
            $_SESSION['success'] = "User updated successfully.";
            header('Location: ../../view/dashboard.php');
        } else {
            $_SESSION['error'] = "Failed to update user.";
            header('Location: ../../view/editUser.php');
        }
        exit;
    }


    public function logout() {
        $_SESSION = array();
        session_destroy();
        header('Location: ../../view/index.php');
        exit;
    }

    
}


$userController=new userController;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sign-up'])) {
    $response = $userController->signUp($_POST);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log-in'])) {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];
    $userController->login($email, $password);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $userController->logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $userController->addUser($_POST);
}

if (isset($_POST['delete-user'])) {
    $userController->deleteUserById($_POST['user_id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $userController = new UserController();
    $userController->updateUser($_POST);
}

