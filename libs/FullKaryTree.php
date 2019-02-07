<?php
class FullKaryTree
{
    private $numOfChilds;
    private $depth;
    private $traverseFilters;
    private $paths;

    public function __construct($numOfChilds, $depth, $traverseFilters = []) {
        $this->numOfChilds = $numOfChilds;
        $this->depth = $depth;
        $this->traverseFilters = $traverseFilters;
        $this->paths = [];
        $this->compute();
    }

    public function getNumOfChilds() {
        return $this->numOfChilds;
    }

    public function getDepth() {
        return $this->depth;
    }

    public function compute() {
        $numOfChilds = $this->numOfChilds;
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
                    //we gather the current information and store it into a node
                    $node = [];
                    $node['value'] = $i;
                    $node['level'] = $curLevel;
                    $node['parent'] = $traverseSequence[$parentPos];

                    $shouldSkip = false;
                    foreach($this->traverseFilters as $filter) {
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

    public function getLeafPaths() {
        return $this->paths;
    }

}
