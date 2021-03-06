<?php
/**
 * The AutoComplete Dictionary
 */
class AutoCompleteDictionary
{
    private $words;
    private $levelHash;
    private $maxLevel;

    public function __construct() {
        $this->words = [];
        $this->levelHash = [];
        $this->maxLevel = 0;
    }

    public function addWord($word) {
        $this->words[] = $word;
    }

    public function build() {
        foreach($this->words as $index => $word) {
            $length = strlen($word);
            for ($i = 0; $i < $length; $i++) {
                $level = $i;

                if ($level > $this->maxLevel) {
                    $this->maxLevel = $level;
                }

                $letter = $word[$i];
                $key = $this->getLevelHashKey($level, $letter);
                if(!isset($this->levelHash[$key][$word])) {
                    $this->levelHash[$key][$word] = $index;
                }
            }
        }
    }

    public function getLevelHash() {
        return $this->levelHash;
    }

    public function getMaxLevel() {
        return $this->maxLevel;
    }

    public function search($prefix) {
        $result = [];
        $length = strlen($prefix);
        for($i = 0; $i < $length; $i++) {
            $level = $i;
            $letter = $prefix[$i];
            $key = $this->getLevelHashKey($level, $letter);
            if (isset($this->levelHash[$key])) {
                if ($i === 0) {
                    $result = array_keys($this->levelHash[$key]);
                } else {
                    $result = array_intersect($result, array_keys($this->levelHash[$key]));
                }
            }
        }

        return $result;
    }

    protected function getLevelHashKey($level, $letter) {
        return "$level$letter";
    }
}

$dictionary = new AutoCompleteDictionary();
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
    'apply'
];
foreach($words as $word) {
    $dictionary->addWord($word);
}
$dictionary->build();
print_r($dictionary->search('app'));
