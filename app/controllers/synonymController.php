<?php
function synonyms($word) {
    $url = "https://api.datamuse.com/words?rel_syn=" . urlencode($word);
    $json = file_get_contents($url);
    $data = json_decode($json, true);

    $result = [];
    foreach ($data as $item) {
        $result[] = $item["word"];
    }
    return $result;
}

print_r(synonyms("fast"));
