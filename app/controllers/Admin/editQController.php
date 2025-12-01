<?php

require_once __DIR__ . '/../../models/admin/editQModel.php';

class editQController
{
    private mysqli $conn;
    private array $data;

    /**
     * @param mysqli $conn  Active DB connection (from dbOOP.php)
     * @param array  $data  Typically $_POST from the admin form
     */
    public function __construct(mysqli $conn, array $data)
    {
        $this->conn = $conn;
        $this->data = $data;
    }

    /**
     * Collects input, calls the model, and stores logs if needed.
     */
    public function handle(): void
    {
        // Model: does all DB work
        $model = new editQModel($this->conn, $this->data);

        // Same logic as your old script: just update the question
        $model->updateQ();

        // Optional: expose logs to the view via session
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['editQLog'] = $model->addQLog;
        }
    }
}
?>