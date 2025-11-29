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
        
        $apiKey = '1bbeb6d2c1825e65968e8968d7d7a3e1aacc6865'; // DANGER DANGER CHANGE THIS - REMEMBER MATHIAS

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
