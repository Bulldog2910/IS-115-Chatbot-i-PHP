<?php

require_once __DIR__ . '/../../models/User/userModel.php';
require_once __DIR__ . '/../../models/admin/selectModel.php';
require_once __DIR__ . '/../../service/registerValidator.php';


class EditUser
{
    private mysqli $conn;
    private User $userModel;

    public function __construct(mysqli $conn)
    {
        $this->conn      = $conn;
        $this->userModel = new User($conn);
    }

   /**
     * handleRequests()
     * ----------------
     * Main entry point for the user-administration page.
     *
     * Workflow:
     *   1. Process POST requests for user updates or deletions.
     *   2. Load database records needed by the admin view (users, questions, keywords).
     *   3. Render the user-management view.
     */
    public function handleRequests(): void
    {
        // STEP 1: Process form submissions (POST requests)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Identify which table and which action the request targets
            $table  = $_POST['identificatorTable']  ?? null;
            $action = $_POST['identificatorAction'] ?? null;

            // Only handle operations directed at the "user" table
            if ($table === 'user') {

                // Delete an existing user
                if ($action === 'delete') {
                    $this->deleteUser();
                }

                // Update an existing user's data
                elseif ($action === 'update') {
                    $this->updateUser();
                }
            }
        }

        // STEP 2: Load admin data (users, questions, keywords)
        // The Select model exposes results like:
        //   - $selectViews->resultChat (users)
        //   - $selectViews->resultQ    (questions)
        //   - $selectViews->resultKey  (keywords)
        $selectViews = new select($this->conn);

        // STEP 3: Render the admin view for editing users
        require __DIR__ . '/../../views/admin/admin.view.php';
    }


    /**
     * deleteUser()
     * ------------
     * Removes a user record using the user ID supplied in the POST request.
     * The method ignores invalid or missing IDs to avoid runtime errors.
     */
    private function deleteUser(): void
    {
        $userId = (int) ($_POST['identificatorId'] ?? 0);

        if ($userId > 0) {
            $this->userModel->deleteUserById($userId);
        }
    }


    /**
     * updateUser()
     * ------------
     * Updates selected user details (username, name, email, role) and optionally
     * replaces the password if a new one was provided.
     *
     * Requirements:
     *   - userId must be valid
     *   - username and email cannot be empty
     *
     * If "newPassword" is an empty string, the existing password remains unchanged.
     */
    private function updateUser(): void
    {
        $userId = (int) ($_POST['identificatorId'] ?? 0);

        // Build raw data array mimicking the registration form structure,
        // so RegisterValidator can reuse the same keys.
        $rawData = [
            'firstName'      => $_POST['firstName']      ?? '',
            'lastName'       => $_POST['lastName']       ?? '',
            'username'       => $_POST['username']       ?? '',
            'mail'           => $_POST['mail']           ?? '',
            'userpassword'   => $_POST['newPassword']    ?? '',      
        ];

        // Run validation
        $validator = new RegisterValidator($rawData);
        $errors    = $validator->validateForUpdate();

        // If validation failed, you might want to store errors in session
        // and show them in the view. For now, we simply stop the update.
        if ($userId <= 0 || !empty($errors)) {
            // Example: store errors in session so the view can show them
            $_SESSION['editUserErrors'] = $errors;
            return;
        }

        // Cleaned + normalized values from validator
        $username  = $validator->getUsername();
        $firstName = $validator->getFirstName();
        $lastName  = $validator->getLastName();
        $mail      = $validator->getEmail();
        $role      = $_POST['role'] ?? 'standard';
        $newPass   = $validator->getPassword(); // can be empty → model will keep old password

        // Perform the actual update in the database
        $this->userModel->updateUserById(
            $userId,
            $username,
            $firstName,
            $lastName,
            $mail,
            $role,
            $newPass
        );
    }
}
?>