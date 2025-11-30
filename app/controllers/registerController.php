<?php

require_once __DIR__ . '/../service/registerValidator.php';
require_once __DIR__ . '/../models/User/userModel.php';

class RegisterController
{
    // Active database connection shared across this controller instance
    private mysqli $conn;

    // Model handling all user-related database operations
    private User $userModel;

    /**
     * __construct()
     * --------------
     * The controller receives an already established mysqli connection
     * (typically created in config/db.php).
     *
     * This connection is stored locally and passed into the User model,
     * ensuring all DB operations share the same connection instance.
     */
    public function __construct(mysqli $conn)
    {
        $this->conn      = $conn;
        $this->userModel = new User($conn);
    }

    /**
     * register()
     * ----------
     * Handles both GET and POST actions for the registration form.
     *
     * Request handling flow:
     *
     * GET request  -> Display empty form.
     *
     * POST request ->
     *   1. Pre-fill $formData with submitted values (so the user does not lose input)
     *   2. Validate fields using RegisterValidator
     *   3. Check email uniqueness in the database
     *   4. If all checks pass → hash password + store user in DB
     *   5. Pass success or error messages to the view
     *
     * The method concludes by requiring the view template, which uses:
     *   - $error
     *   - $successMsg
     *   - $data
     */
    public function register(): void
    {
        // Default values before form submission
        $errors  = [];
        $success = '';

        /**
         * Collect initial form values.
         * These values repopulate the form when validation fails.
         */
        $formData = [
            'firstName'      => $_POST['firstName']      ?? '',
            'lastName'       => $_POST['lastName']       ?? '',
            'username'       => $_POST['username']       ?? '',
            'mail'           => $_POST['mail']           ?? '',
            'userpassword'   => $_POST['userpassword']   ?? '',
            'repeatpassword' => $_POST['repeatpassword'] ?? '',
        ];
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /**
             * STEP 1 – Validate basic input (format, required fields, password rules, etc.)
             * The validator processes ONLY the raw form data.
             */
            $validator = new RegisterValidator($_POST);
            $errors    = $validator->validate();

            /**
             * STEP 2 – Check if the email already exists in the database.
             * This is a database-level validation and must be performed
             * AFTER the basic validator approves the email format.
             */
            if (empty($errors)) {
                if ($this->userModel->existsByEmail($formData['mail'])) {
                    $errors[] = "E-postadressen er allerede registrert.";
                }
            }

            /**
             * STEP 3 – If all validation passed (no errors), create new user
             * and store the hashed password in the database.
             */
            if (empty($errors)) {
                // Secure hashing using PHP’s default algorithm (bcrypt/argon2)
                $hashedPassword = password_hash($formData['userpassword'], PASSWORD_DEFAULT);

                // Create the user using the User model
                $this->userModel->createUser([
                    'firstName' => $formData['firstName'],
                    'lastName'  => $formData['lastName'],
                    'username'  => $formData['username'],
                    'mail'      => $formData['mail'],
                    'password'  => $hashedPassword,
                ]);

                // Success message sent to the view
                $success = "Bruker registrert!";

                // Clear passwords to avoid redisplaying sensitive data
                $formData['userpassword']   = '';
                $formData['repeatpassword'] = '';

                header("Location: ../public/Index.php");
                exit;
            }
        }

        /**
         * Prepare variables for the view.
         * The view expects these exact names to exist in scope.
         */
        $error      = $errors;
        $successMsg = $success;
        $data       = $formData;

        // Load the HTML/PHP view that presents the form and results
        require __DIR__ . '/../views/registerUser.view.php';
    }
}
?>
