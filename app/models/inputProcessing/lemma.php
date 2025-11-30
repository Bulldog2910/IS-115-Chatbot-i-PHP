<?php
class lemma{
    public $lemmainput;
    public $lemmaArr;
    public $lemmaSentence;
    public function __construct($wordArr)
    {
        foreach($wordArr as $word){
            $this->lemmainput .= " " . $word;
        }
        $path = realpath(__DIR__ . '/../../../text.text');

        if ($path === false) {
            echo $path;
            die("Error: Secret file not found. Path resolved incorrectly.");
            
        }

        if (!is_readable($path)) {
            die("Error: Secret file exists but is not readable. Check file permissions.");
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            die("Error: Failed to read secret file.");
        }

        $apiKey = trim($contents);
        $api = fopen($path, "r");
        if ($api) {
        // Get the size of the file to read the entire content
        $filesize = filesize($path);

        // Read the entire content of the file
        $contents = fread($api, $filesize);

        fclose($api); // Close the file handle
        } else {
            echo "Error: Could not open the file.";
        }
        
        $apiKey = $contents;

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

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo "cURL error: " . curl_error($curl);
        }

        // Just print the raw response
        $data = json_decode($response, true);

        // Extract lemmas into an array
        if (isset($data['tokens'])) {
            foreach ($data['tokens'] as $token) {
                if (isset($token['lemma'])) {
                    $this->lemmaArr[] = $token['lemma'];
                    $this->lemmaSentence .= $token['lemma'] . " ";
                }
            }
        }
    }
    public function getLemma(){
        return $this->lemmaArr;
    }
}
