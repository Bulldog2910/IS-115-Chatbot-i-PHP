<?php

class AdminController
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Main handler for non-user admin actions:
     *  - keywords
     *  - questions
     *  - reset database
     *  - load overview tables
     */
    public function handle(): void
    {
        $identificator = $_POST['identificatorTable'] ?? 'wrong';
        $keywordUpdate = $_POST['identificator'] ?? '';

        // KEYWORD EDIT
         if ($_SERVER['REQUEST_METHOD'] === 'POST' && $identificator === 'keyword') {
            //If edit keyword button is pressed run editKeywordController
            if($keywordUpdate == 'keywordUpdate'){
                include __DIR__ . '/editKeywordController.php';
                //Make instance of editKeywordController
                $editkeyword = new editKeywordController($_POST);
                $editkeyword->handle();
                
            }
            include __DIR__ . '/../../views/admin/keywordForm.php';
        }

        // RESET DATABASE
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $identificator === 'Reset Database') {
            // Use existing $this->conn instead of including db config again
            $this->conn->query("DROP DATABASE IF EXISTS `faquiachatbot`");
            header("Location: ../public/index.php");
            exit;
        }

        // QUESTION EDIT / ADD
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $identificator === 'question') {
            if (isset($_POST['Qtype'])) {
                if ($_POST['Qtype'] === 'editQ') {
                    require __DIR__ . '/editQController.php';
                }
                if ($_POST['Qtype'] === 'addQ') {
                    require __DIR__ . '/addQController.php';
                    $question = new addQController($this->conn, $_POST);
                }
            }

            include __DIR__ . '/../../views/admin/questionsForm.php';
        }

        // ALWAYS: load admin tables (questions, keywords, users)
        require_once __DIR__ . '/../../models/admin/selectModel.php';
        $selectViews = new select($this->conn);

        // Render the main admin dashboard view (for Qs/keywords)
        require __DIR__ . '/../../views/admin/admin.view.php';
    }
}
?>