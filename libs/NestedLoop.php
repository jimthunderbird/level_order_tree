<?php
class NestedLoop
{
    private $width;
    private $depth;
    private $filters;
    private $paths;

    public function __construct($width, $depth, $filters) {
        $this->width = $width;
        $this->depth = $depth;
        $this->filters = $filters;
        $this->paths = [];
        $this->compute();
    }

    public function compute() {
        $numOfChilds = $this->width;
        $maxLevel = $this->depth;

        $traverseSequence = [[
            'value' => 0,
            'level' => 0,
            'parent' => null,
            'path' => [],
            'pathHash' => []
        ]];

        $parentPos = -1;

        while(true) {
            $parentPos ++;
            $curLevel = $traverseSequence[$parentPos]['level'] + 1;
            if ($curLevel <= $maxLevel) {
                for($i = 1; $i <= $numOfChilds; $i++) {
                    //we gather and current information and store it into a node
                    $node = [];
                    $node['value'] = $i;
                    $node['level'] = $curLevel;
                    $node['parent'] = $traverseSequence[$parentPos];

                    //filter, only find the unique sequence, aka, combination
                    $shouldSkip = false;
                    foreach($this->filters as $filter) {
                        if ($filter($node) === FALSE) {
                            $shouldSkip = true;
                            break;
                        }
                    }

                    if ($shouldSkip) {
                        continue;
                    }

                    $path = $traverseSequence[$parentPos]['path'];
                    $path[] = $i;
                    $pathHash = $traverseSequence[$parentPos]['pathHash'];
                    $pathHash[$i] = 1;

                    $node['path'] = $path;
                    $node['pathHash'] = $pathHash;

                    $traverseSequence[] = $node;
                }
            } else {
                break;
            }
        }

        foreach($traverseSequence as $node) {
            if ($node['level'] === $maxLevel) {
                $this->paths[] = $node['path'];
            }
        }
    }

    public function getPaths() {
        return $this->paths;
    }
}

