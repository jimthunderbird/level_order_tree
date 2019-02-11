<?php
/**
 * The AutoComplete Dictionary
 */
class AutoCompleteDictionary2
{
    private $words;
    private $patternHash;

    public function __construct() {
        $this->wordPos = 0;
        $this->words = [];
        $this->patternHash = [];
    }

    public function addWord($word) {
        $length = strlen($word);

        for ($k = 0; $k < $length; $k++) {
            if ($k === 0) {
                $pattern = $word;
            } else {
                $pattern = substr($word, 0, -$k);
            }
            $this->patternHash[$pattern][] = $this->wordPos;
        }

        $this->words[] = $word;
        $this->wordPos++;
    }

    public function search($pattern) {
        $result = [];
        $indexes = [];
        if (isset($this->patternHash[$pattern])) {
            $indexes = $this->patternHash[$pattern];
        }
        foreach($indexes as $index) {
            $word = $this->words[$index];
            $result[$word] = $this->words[$index];
        }
        return array_keys($result); //we do not want duplicates
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
