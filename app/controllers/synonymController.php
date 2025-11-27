<?php
require_once __DIR__ . '/../models/chatbotModel.php';

class ChatbotController
{
    public function handleQuestion()
    {
        /**
         * Controller method that handles:
         *  - Reading the question from the POST request
         *  - Validating the input
         *  - Calling the chatbot model to search for matching questions
         *  - Optionally fetching synonyms for each word
         *  - Preparing values for the view
         */

        // Values that the view is expected to use
        $userMessage = '';
        $botReply    = '';
        $results     = [];
        $synonyms    = [];
        $error       = '';

        // 1. Only handle form submission if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Safely read the 'question' field from the POST data
            $question = $_POST['question'] ?? '';

            // 2. Simple validation: check that the user actually wrote something
            if (empty($question)) {
                // Validation error message shown to the user
                $error = "Du må skrive et spørsmål.";
            } else {
                // Store the original user input so the view can display it back
                $userMessage = $question;

                // 3. Prepare data structure expected by the model
                //    The model's constructor currently expects an array with key 'question'
                $Q = ['question' => $question];

                // 4. Instantiate the model and fetch matching questions from the database
                $model   = new chatbotModel($Q);

                // getQArr() returns an array like: [ questionId => questionDescription, ... ]
                $results = $model->getQArr();

                // 5. Build a bot reply based on the search results
                if (!empty($results)) {
                    // reset($results) returns the first questionDescription in the array
                    $first    = reset($results);
                    $botReply = $first;
                } else {
                    // Fallback message when no matching question is found
                    $botReply = "Jeg fant dessverre ingen svar på det du spurte om.";
                }

                // 6. (Optional) Fetch synonyms for each word in the question
                $words = explode(" ", strtolower($question));

                foreach ($words as $w) {
                    /**
                     * For each individual word, we call the model's synonym method.
                     * 
                     * Assumptions:
                     *  - getSynonymsFromDatamuse() is public in the model
                     *  - The method returns an array of synonyms (or an empty array on failure)
                     */
                    $synonyms[$w] = $model->getSynonymsFromDatamuse($w);
                }
            }
        }
        return [$userMessage, $botReply, $results, $synonyms, $error];
    }
}
?>
