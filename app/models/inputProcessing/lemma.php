<?php
/*
 * lemma Class
 *
 * Purpose:
 *   - Take an array of words (user input), send it to an NLP API (nlpcloud.io),
 *     and extract the lemma (base form) of each token.
 *   - Store lemmas as an array and reconstruct the sentence with lemmatized words.
 */
class lemma {
    public $lemmainput;       // Original input as a string
    public $lemmaArr = [];    // Array of lemmas for each token
    public $lemmaSentence;    // Reconstructed sentence from lemmas

    /**
     * Constructor
     * @param array $wordArr Array of input words
     */
    public function __construct($wordArr)
    {
        // Join words into a single string
        $this->lemmainput = implode(" ", $wordArr);

        // Resolve the API key file
        $path = realpath(__DIR__ . '/../../../text.text');

        if ($path === false) {
            die("Error: Secret file not found. Path resolved incorrectly.");
        }

        if (!is_readable($path)) {
            die("Error: Secret file exists but is not readable. Check file permissions.");
        }

        // Read the API key from the file
        $apiKey = file_get_contents($path);
        if ($apiKey === false) {
            die("Error: Failed to read secret file.");
        }
        $apiKey = trim($apiKey);

        // Initialize cURL for NLPCloud API
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.nlpcloud.io/v1/en_core_web_lg/tokens",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Token " . $apiKey,
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode(["text" => $this->lemmainput]),
        ]);

        // Execute API request
        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo "cURL error: " . curl_error($curl);
        }

        curl_close($curl);

        // Decode JSON response
        $data = json_decode($response, true);

        // Extract lemmas for each token
        if (isset($data['tokens'])) {
            foreach ($data['tokens'] as $token) {
                if (isset($token['lemma'])) {
                    $this->lemmaArr[] = $token['lemma'];
                    $this->lemmaSentence .= $token['lemma'] . " ";
                }
            }
            $this->lemmaSentence = trim($this->lemmaSentence); // remove trailing space
        }
    }

    /**
     * Get the array of lemmatized tokens
     * @return array Lemmas of the input words
     */
    public function getLemma()
    {
        return $this->lemmaArr;
    }
}
?>
