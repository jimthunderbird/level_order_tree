<?php
//0,1,2,3,4
$numOfChilds = 13;
$maxLevel = 4;

$traverseSequence = [[
    'value' => 0,
    'level' => 0,
    'parent' => -1,
    'path' => [],
    'pathHash' => []
]];

$parentPos = -1;

$result = [];
while(true) {
    $parentPos ++;
    $curLevel = $traverseSequence[$parentPos]['level'] + 1;
    if ($curLevel <= $maxLevel) {
        for($i = 1; $i <= $numOfChilds; $i++) {
            $pathHash = $traverseSequence[$parentPos]['pathHash'];

            $filters = [
                isset($pathHash[$i]),
            ];

            //filter, only find the unique sequence, ake, combination
            $shouldSkip = false;
            foreach($filters as $filter) {
                if ($filter) {
                    $shouldSkip = true;
                    break;
                }
            }

            if ($shouldSkip) {
                continue;
            }

            $path = $traverseSequence[$parentPos]['path'];
            $path[] = $i;
            $pathHash[$i] = 1;
            $traverseSequence[] = [
                'value' => $i,
                'parent' => $parentPos,
                'level' => $curLevel,
                'path' => $path,
                'pathHash' => $pathHash
            ];
        }
    } else {
        break;
    }
}

$counter = 0;
foreach($traverseSequence as $node) {
    if ($node['level'] === $maxLevel) {
        $counter ++;
        print implode(".", $node['path'])."\n";
    }
}
