<?php

class RegisterValidator {
    private string $firstName;
    private string $lastName;
    private string $username;
    private string $email;
    private string $password;
    private string $repeatPassword;

    private array $errors = [];

    /**
     * Constructor receives raw form data (typically $_POST)
     * and immediately sanitizes the expected fields.
     */
    public function __construct(array $data) {
        $this->firstName      = $this->cleanInput($data['firstName']      ?? '');
        $this->lastName       = $this->cleanInput($data['lastName']       ?? '');
        $this->username       = $this->cleanInput($data['username']       ?? '');
        $this->email          = $this->cleanInput($data['mail']           ?? '');
        $this->password       = $this->cleanInput($data['userpassword']   ?? '');
        $this->repeatPassword = $this->cleanInput($data['repeatpassword'] ?? '');
    }

    /**
     * Basic input cleaning for all fields. This makes sure that:
     * - leading/trailing whitespace is removed
     * - stray backslashes are stripped
     * - HTML is safely escaped to prevent injection in views
     */
    private function cleanInput(string $data): string {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        return $data;
    }

    /**
     * Entry point for validation logic.
     * The controller calls this and receives a list of error messages.
     */
    public function validate(): array {
        $this->checkRequired();
        $this->checkEmail();
        $this->checkPassword();
        $this->checkPasswordMatch();

        return $this->errors;
    }

    /**
     * Ensure that all mandatory fields are filled in.
     * Empty values are added as human-readable error messages.
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
     * Validate email format using PHP’s built-in filter.
     * Only runs if the email is non-empty.
     */
    private function checkEmail(): void {
        if ($this->email !== '' && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "'{$this->email}' er ikke en gyldig e-postadresse.";
        }
    }

    /**
     * Validate password strength:
     * - length >= 9
     * - at least one uppercase letter (A–Z, Æ, Ø, Å)
     * - at least one digit
     * - at least one special character
     */
    private function checkPassword(): void {
        $pass = $this->password;

        // Empty password is already handled in checkRequired()
        if ($pass === '') {
            return;
        }

        $feil = [];

        if (strlen($pass) < 9)                 $feil[] = "minst 9 tegn";
        if (!preg_match('/[A-ZÆØÅ]/', $pass))  $feil[] = "minst én stor bokstav";
        if (!preg_match('/[0-9]/', $pass))     $feil[] = "minst ett tall";
        if (!preg_match('/[\W_]/', $pass))     $feil[] = "minst ett spesialtegn";

        if (!empty($feil)) {
            $this->errors[] = "Passordet er ugyldig: mangler " . implode(', ', $feil) . ".";
        }
    }

    /**
     * Ensure that the two password fields match exactly.
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
