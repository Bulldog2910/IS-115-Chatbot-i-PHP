<?php

class RegisterValidator {
    // Store cleaned form values
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $email;
    private string $password;
    private string $repeatPassword;

    // Collect all validation errors
    private array $errors = [];

    /**
     * Constructor
     * ----------- 
     * Accepts raw user input (usually $_POST) and normalizes/sanitizes
     * all expected fields. This ensures the validation methods operate on
     * safe and consistently formatted values.
     */
    public function __construct(array $data) {
        // Clean input for each field or fall back to empty string
        $this->firstName      = $this->cleanInput($data['firstName']      ?? '');
        $this->lastName       = $this->cleanInput($data['lastName']       ?? '');
        $this->username       = $this->cleanInput($data['username']       ?? '');
        $this->email          = $this->cleanInput($data['mail']           ?? '');
        $this->password       = $this->cleanInput($data['userpassword']   ?? '');
        $this->repeatPassword = $this->cleanInput($data['repeatpassword'] ?? '');
    }

    /**
     * cleanInput()
     * -----------
     * Performs basic sanitization on all fields:
     * 1. trim() removes leading/trailing whitespace
     * 2. stripslashes() removes any accidental backslashes
     * 3. htmlspecialchars() prevents HTML injection when values are
     *    later echoed into a view
     *
     * This does **not** defend against SQL injection (prepared statements
     * handle that). It ensures consistent, safe text for validation and display.
     */
    private function cleanInput(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        return $data;
    }

    /**
     * validate()
     * ----------
     * The main method that runs all validation rules sequentially.
     * Returns an array of error messages that the controller can pass
     * back to the view layer.
     */
    public function validate(): array {
        $this->checkRequired();
        $this->checkFirstNameFormat();
        $this->checkLastNameFormat();
        $this->checkEmail();
        $this->checkPassword();
        $this->checkPasswordMatch();

        return $this->errors;
    }

    /**
     * validateForUpdate()
     * -------------------
     * Validation entry point for updating an existing user.
     *
     * Differences from validate():
     *  - Password fields are optional.
     *  - If new password fields are left empty → password is not validated.
     */
    public function validateForUpdate(): array {
        // Reset any previous errors
        $this->errors = [];

        // For update: require only basic identity/contact fields
        $this->checkRequiredForUpdate();
        $this->checkFirstNameFormat();
        $this->checkLastNameFormat();
        $this->checkEmail();

        // Password rules only apply if at least one password field is provided
        if ($this->password !== '' || $this->repeatPassword !== '') {
            $this->checkPassword();
            $this->checkPasswordMatch();
        }

        return $this->errors;
    }

    /**
     * checkRequired()
     * ----------------
     * Ensures all mandatory fields contain a value.
     * This prevents further validation from operating on empty strings
     * and provides user-friendly instructions.
     */
    private function checkRequired(): void {
        if ($this->firstName === '')        $this->errors[] = "Fornavn må fylles ut.";
        if ($this->lastName === '')         $this->errors[] = "Etternavn må fylles ut.";
        if ($this->username === '')         $this->errors[] = "Brukernavn må fylles ut.";
        if ($this->email === '')            $this->errors[] = "E-post må fylles ut.";
        if ($this->password === '')         $this->errors[] = "Passord må fylles ut.";
        if ($this->repeatPassword === '')   $this->errors[] = "Gjenta passord må fylles ut.";
    }

    /**
     * checkRequiredForUpdate()
     * ------------------------
     * Required-field check for user updates.
     *
     * For editing an existing user we require:
     *  - firstName
     *  - lastName
     *  - username
     *  - email
     *
     * Password fields are optional here, because an admin/user may update
     * profile data without changing the password.
     */
    private function checkRequiredForUpdate(): void {
        if ($this->firstName === '')  $this->errors[] = "Fornavn må fylles ut.";
        if ($this->lastName === '')   $this->errors[] = "Etternavn må fylles ut.";
        if ($this->username === '')   $this->errors[] = "Brukernavn må fylles ut.";
        if ($this->email === '')      $this->errors[] = "E-post må fylles ut.";
    }

    private function checkFirstNameFormat(): void {
        /**
         * If the field is empty, skip further validation.
         */
        if ($this->firstName === '') return;

        /**
         * Validate allowed characters:
         * - A–Z (upper and lower case)
         * - Norwegian letters (Æ Ø Å and æ ø å)
         * - Space
         * - Hyphen
         *
         * The `u` modifier ensures proper UTF-8 handling of multibyte characters.
         */
        if (!preg_match('/^[A-Za-zÆØÅæøå \-]+$/u', $this->firstName)) {
            $this->errors[] = "Fornavn inneholder ugyldige tegn.";
            return;
        }

        /**
         * Normalize the name by:
         * 1. Converting the entire string to lowercase (UTF-8 safe)
         * 2. Converting to Title Case (first letter uppercase, rest lowercase)
         *
         * mb_convert_case() ensures correct behavior for Norwegian characters.
         */
        $this->firstName = mb_convert_case(
            mb_strtolower($this->firstName),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }  

    private function checkLastNameFormat(): void {
        /**
         * Skip validation if the field is empty.
         */
        if ($this->lastName === '') return;

        /**
         * Validate that the last name only contains allowed characters.
         * Same rules as for first name: letters, spaces, and hyphens.
         */
        if (!preg_match('/^[A-Za-zÆØÅæøå \-]+$/u', $this->lastName)) {
            $this->errors[] = "Etternavn inneholder ugyldige tegn.";
            return;
        }

        /**
         * Normalize casing:
         * Convert to lowercase, then apply proper Title Case formatting.
         */
        $this->lastName = mb_convert_case(
            mb_strtolower($this->lastName),
            MB_CASE_TITLE,
            'UTF-8'
        );
}

    /**
     * checkEmail()
     * ------------
     * Validates proper email format using PHP’s built-in FILTER_VALIDATE_EMAIL.
     * Only executes if an email was actually provided.
     */
    private function checkEmail(): void {
        if ($this->email !== '' && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "'{$this->email}' er ikke en gyldig e-postadresse.";
        }
    }

    /**
     * checkPassword()
     * ----------------
     * Validates password strength according to the project’s requirements:
     *  - Minimum length of 9 characters  
     *  - At least one uppercase letter (supports Norwegian chars Æ Ø Å)
     *  - At least one digit  
     *  - At least one special character  
     *
     * Weaknesses are collected into an array and returned as a single
     * readable error message.
     */
    private function checkPassword(): void {
        $pass = $this->password;

        // Skip if the field is empty (already handled in checkRequired)
        if ($pass === '') {
            return;
        }

        $feil = [];

        // Check individual strength requirements
        if (strlen($pass) < 9)                 $feil[] = "minst 9 tegn";
        if (!preg_match('/[A-ZÆØÅ]/', $pass))  $feil[] = "minst én stor bokstav";
        if (!preg_match('/[0-9]/', $pass))     $feil[] = "minst ett tall";
        if (!preg_match('/[\W_]/', $pass))     $feil[] = "minst ett spesialtegn";

        // If any requirements are missing, add a combined error message
        if (!empty($feil)) {
            $this->errors[] = "Passordet er ugyldig: mangler " . implode(', ', $feil) . ".";
        }
    }

    /**
     * checkPasswordMatch()
     * --------------------
     * Confirms that password and repeat-password fields contain
     * identical values. Only runs if both fields are non-empty
     * to avoid duplicate error messages.
     */
    private function checkPasswordMatch(): void {
        if (
            $this->password !== '' &&
            $this->repeatPassword !== '' &&
            $this->password !== $this->repeatPassword
        ) {
            $this->errors[] = "Passordene er ikke like.";
        }
    }
}
?>