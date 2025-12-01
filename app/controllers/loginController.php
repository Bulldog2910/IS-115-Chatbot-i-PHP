<?php

require_once __DIR__ . '/../config/db.php'; // Starts Db connection
require_once __DIR__ . '/../models/user/userModel.php'; // Loads the User model class

class LoginController
{
    private User $userModel;      // Handles DB queries related to users
    private array $errorMsg = []; // Used to store all validation or login errors
    private string $email = '';   // Stores sanitized email input for reuse in the form

    public function __construct(mysqli $conn)
    {
        // Inject the DB connection into the User model
        $this->userModel = new User($conn);
    }

    public function handleRequest(): void
    {
        // Reset values for each request to avoid stale data
        $this->errorMsg = [];
        $this->email = '';

        // If the login form was submitted, process it
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $this->processLogin();
        }

        // Make these available to the view
        $errorMsg = $this->errorMsg;
        $email    = $this->email;

        // Load the login page view
        include __DIR__ . '/../views/login.view.php';
    }

    private function processLogin(): void
    {
        // Read and sanitize email and password input
        $this->email = trim($_POST['email'] ?? '');
        $password    = trim($_POST['password'] ?? '');

        // Validate email field
        if (!$this->email) {
            $this->errorMsg['email'] = "Email must be provided"; // Email not entered
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            // Email entered but invalid format
            $this->errorMsg['email'] = "Invalid email address";
        }

        // Validate that password field is not empty
        if (!$password) {
            $this->errorMsg['password'] = "Password must be provided";
        }

        // Stop here if basic validation failed
        if (count($this->errorMsg)) {
            return;
        }

        // Fetch the user record based on the email
        $user = $this->userModel->findByEmail($this->email);

        // If no user with that email exists
        if (!$user) {
            $this->errorMsg['login'] = "Incorrect email or password";
            return;
        }

        // Verify that the raw password typed by the user matches the stored hash.
        // password_verify() safely compares the input to the hash.
        if (!password_verify($password, $user['userpassword'])) {
            $this->errorMsg['Wrong password'] = "Wrong password";
            return;
        }

        // Start session if one does not already exist
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Store user data in session (used to confirm logged-in state)
        $_SESSION['user_id']  = $user['id'] ?? 1; // Fallback because column name may differ
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        session_regenerate_id(true);

        // Redirect user to the application after successful login
        // (Relative path is used to avoid redirecting to server root)
        header("Location: ../public/Index.php");
        exit();
    }
}
?>