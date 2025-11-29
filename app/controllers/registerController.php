<?php

require_once __DIR__ . '/../service/registerValidator.php';
require_once __DIR__ . '/../models/User/registerModel.php';

class RegisterController
{
    // Shared mysqli connection for this request
    private mysqli $conn;

    // Model responsible for persisting new users
    private NewUser $userModel;

    /**
     * __construct()
     * --------------
     * The controller receives a ready-to-use mysqli connection
     * (usually created in config/db.php).
     *
     * It also instantiates the NewUser model, which encapsulates
     * all database logic related to creating users.
     */
    public function __construct(mysqli $conn)
    {
        $this->conn      = $conn;
        $this->userModel = new NewUser($conn);
    }

    /**
     * register()
     * ----------
     * Handles both GET and POST for the registration page.
     *
     * Flow:
     *  - On GET:
     *      * Show empty form (or previously submitted data if needed)
     *  - On POST:
     *      * Validate user input using RegisterValidator
     *      * If validation passes → hash password and create user through model
     *      * If validation fails → pass errors and form values to the view
     *
     * The method always ends by loading the view
     * `../views/registerUser.view.php`, which uses:
     *  - $error      : array of error messages
     *  - $successMsg : success message string
     *  - $data       : array of form values to refill the form
     */
    public function register(): void
    {
        // Default state: no errors and no success message
        $errors  = [];
        $success = '';

        /**
         * Pre-populate form data:
         * This ensures that if validation fails, the user does not lose
         * everything they typed. We reuse this array later in both
         * the error and success cases.
         */
        $formData = [
            'firstName'      => $_POST['firstName']      ?? '',
            'lastName'       => $_POST['lastName']       ?? '',
            'username'       => $_POST['username']       ?? '',
            'mail'           => $_POST['mail']           ?? '',
            'userpassword'   => $_POST['userpassword']   ?? '',
            'repeatpassword' => $_POST['repeatpassword'] ?? '',
        ];

        // Only run validation and insert logic on HTTP POST (form submission)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1) Validate raw POST data using a dedicated validator service
            $validator = new RegisterValidator($_POST);
            $errors    = $validator->validate();

            // 2) If no validation errors, proceed with user creation
            if (empty($errors)) {
                // Securely hash the password before persisting it
                $hashedPassword = password_hash($formData['userpassword'], PASSWORD_DEFAULT);

                // Delegate database insert to the model
                $this->userModel->createUser([
                    'firstName' => $formData['firstName'],
                    'lastName'  => $formData['lastName'],
                    'username'  => $formData['username'],
                    'mail'      => $formData['mail'],
                    'password'  => $hashedPassword,
                ]);

                // Inform the view that registration succeeded
                $success = "Bruker registrert!";

                // Clear password fields so they are not shown back to the user
                $formData['userpassword']   = '';
                $formData['repeatpassword'] = '';
            }
        }

        /**
         * Expose data to the view:
         * The included view file `registerUser.view.php` expects
         * these variable names in the local scope.
         */
        $error      = $errors;
        $successMsg = $success;
        $data       = $formData;

        // Render the registration form (with errors/success/data if applicable)
        require __DIR__ . '/../views/registerUser.view.php';
    }
}
?>