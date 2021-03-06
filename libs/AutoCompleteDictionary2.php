<?php
/**
 * The AutoComplete Dictionary
 */
class AutoCompleteDictionary2
{
    private $patternHash;

    public function __construct() {
        $this->patternHash = [];
    }

    public function addWord($word) {
        $length = strlen($word);

        $pattern = "";
        for ($k = 0; $k < $length; $k++) {
            $pattern .= $word[$k];
            $this->patternHash[$pattern][$word] = 1; //we do not want duplicates
        }
    }

    public function search($pattern) {
        $result = [];
        if (isset($this->patternHash[$pattern])) {
            $result = array_keys($this->patternHash[$pattern]);
        }
        return $result;
    }
}

$dictionary = new AutoCompleteDictionary2();
$words = [
    'ape',
    'ace',
    'ame',
    'apple',
    'be',
    'ben',
    'build',
    'bull',
    'boll',
    'ime',
    'ice',
    'box',
    'bottle',
    'fox',
    'api',
    'jim',
    'jit',
    'icecream',
    'knot',
    'knowledge',
    'cool',
    'application',
    'apply',
    'coke'
];
foreach($words as $word) {
    $dictionary->addWord($word);
}
print_r($dictionary->search('ap'));
