<?php
class stopword{
    public $stopwordArr;
    public $inputText;
    
    public function __construct($strArr)
    {
        $apiKey = '1bbeb6d2c1825e65968e8968d7d7a3e1aacc6865'; // keep key safe
        foreach($strArr as $word){
            $this->inputText .= $word . " ";
        }

        
        $curl = curl_init();

        // NLP Cloud doesn’t have a dedicated 'remove stopwords' endpoint for all models.
        // But you can use the `/tokens` endpoint, then filter out stopwords using the `is_stop` field.
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.nlpcloud.io/v1/en_core_web_lg/tokens",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Token " . $apiKey,
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode(["text" => $this->inputText]),
        ]);

        $response = curl_exec($curl);
        print_r($response);

        if (curl_errno($curl)) {
            echo "cURL error: " . curl_error($curl);
            exit;
        }

        // Decode response
        $data = json_decode($response, true);

        // Collect tokens that are NOT stopwords
        $filteredTokens = [];
        if (isset($data['tokens'])) {   
            foreach ($data['tokens'] as $token) {
                // Fallbacks if fields are missing
                $lemma = $token['lemma'] ?? $token['text']; 
                $isStop = $token['is_stop'] ?? false; 

                if (!$isStop) {
                    $filteredTokens[] = $lemma; // store lemmas instead of raw text
                }
            }
        }

        $this->stopwordArr = $filteredTokens;
        
        }

        public function getStopwordArr(){

            return $this->stopwordArr;
        }
}

