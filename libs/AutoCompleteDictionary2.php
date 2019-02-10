<?php
/**
 * The AutoComplete Dictionary
 */
class AutoCompleteDictionary2
{
    private $words;
    private $levelHash;
    private $maxLevel;

    public function __construct() {
        $this->wordPos = 0;
        $this->words = [];
        $this->levelHash = [];
        $this->maxLevel = 0;
    }

    public function addWord($word) {
        $length = strlen($word);

        for ($k = 0; $k < $length; $k++) {
            $level = $length - 1 - $k;
            if ($k === 0) {
                $pattern = $word;
            } else {
                $pattern = substr($word, 0, -$k);
            }
            $this->levelHash["$level$pattern"][] = $this->wordPos;
        }

        $this->words[] = $word;
        $this->wordPos++;
    }

    public function getLevelHash() {
        return $this->levelHash;
    }

    public function getMaxLevel() {
        return $this->maxLevel;
    }

    public function search($prefix) {
        $result = [];
        $indexes = [];
        $level = strlen($prefix) - 1;
        if (isset($this->levelHash["$level$prefix"])) {
            $indexes = $this->levelHash["$level$prefix"];
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
];
foreach($words as $word) {
    $dictionary->addWord($word);
}
print_r($dictionary->search('bull'));
