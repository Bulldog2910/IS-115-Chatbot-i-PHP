<?php

class SynonymModel
{
    /**
     * Fetch synonyms using the external Datamuse API.
     *
     * Example request:
     *      https://api.datamuse.com/words?rel_syn=fast
     *
     * Returns:
     *      An array of synonym strings.
     */
    public function getSynonymsFromDatamuse(string $word): array
    {
        $url = 'https://api.datamuse.com/words?rel_syn=' . urlencode($word);

        // Safely try to fetch the data (suppress warnings)
        $json = @file_get_contents($url);

        if ($json === false) {
            // API unreachable, timeout, or offline
            return [];
        }

        $data = json_decode($json, true);

        if (!is_array($data)) {
            return [];
        }

        $result = [];

        foreach ($data as $item) {
            if (isset($item['word'])) {
                $result[] = $item['word'];
            }
        }

        return $result;
    }
}
?>