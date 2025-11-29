<?php

require_once __DIR__ . '/../service/registerValidator.php';
require_once __DIR__ . '/../models/User/registerModel.php';

class RegisterController
{
    private mysqli $conn;
    private NewUser $userModel;

    /**
     * Controller receives the DB connection and constructs the model.
     */
    public function __construct(mysqli $conn)
    {
        $this->conn      = $conn;
        $this->userModel = new NewUser($conn);
    }

    /**
     * Handles both GET and POST for the registration page.
     */
    public function register(): void
    {
        $errors  = [];
        $success = '';

        // Keep form values so user doesn’t lose input on validation errors
        $formData = [
            'firstName'      => $_POST['firstName']      ?? '',
            'lastName'       => $_POST['lastName']       ?? '',
            'username'       => $_POST['username']       ?? '',
            'mail'           => $_POST['mail']           ?? '',
            'userpassword'   => $_POST['userpassword']   ?? '',
            'repeatpassword' => $_POST['repeatpassword'] ?? '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1) Run validation on POST data
            $validator = new RegisterValidator($_POST);
            $errors    = $validator->validate();

            // 2) If no errors, create user via the model
            if (empty($errors)) {
                // Hash password before saving
                $hashedPassword = password_hash($formData['userpassword'], PASSWORD_DEFAULT);

                $this->userModel->createUser([
                    'firstName' => $formData['firstName'],
                    'lastName'  => $formData['lastName'],
                    'username'  => $formData['username'],
                    'mail'      => $formData['mail'],
                    'password'  => $hashedPassword,
                ]);

                $success = "Bruker registrert!";

                // Optionally clear password fields after success
                $formData['userpassword']   = '';
                $formData['repeatpassword'] = '';
            }
        }

        // Make variables available to view
        $error      = $errors;
        $successMsg = $success;
        $data       = $formData;

        // Load the view
        require __DIR__ . '/../views/registerUser.view.php';
    }
}
