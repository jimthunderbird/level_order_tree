<?php
class FullKaryTree
{
    private $numOfChilds;
    private $depth;
    private $traverseSequence;
    private $traverseFilters;

    public function __construct($numOfChilds, $depth, $traverseFilters = []) {
        $this->numOfChilds = $numOfChilds;
        $this->depth = $depth;
        $this->traverseFilters = $traverseFilters;
        $this->traverseSequence = [];
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

        $rootNode = [
            'value' => 0,
            'level' => 0,
            'parent' => null,
            'path' => [],
            'pathHash' => []
        ];

        $traverseSequence = [$rootNode];

        $parentPos = -1;

        while(true) {
            $parentPos ++;
            $parent = $traverseSequence[$parentPos];
            $curLevel = $parent['level'] + 1;
            if ($curLevel <= $maxLevel) {
                for($i = 1; $i <= $numOfChilds; $i++) {
                    //we gather the current information and store it into a node
                    $node = [];
                    $node['value'] = $i;
                    $node['level'] = $curLevel;
                    $node['parent'] = $parent;

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

                    $path = $parent['path'];
                    $path[] = $i;
                    $pathHash = $parent['pathHash'];
                    $pathHash[$i] = 1;

                    $node['path'] = $path;
                    $node['pathHash'] = $pathHash;

                    $traverseSequence[] = $node;
                }
            } else {
                break;
            }
        }

        $this->traverseSequence = $traverseSequence;
    }

    public function getPathsAtLevel($level) {
        $result = [];
        foreach($this->traverseSequence as $node) {
            if ($node['level'] === $level) {
                $result[] = $node['path'];
            }
        }
        return $result;
    }

    public function getLeafPaths() {
        return $this->getPathsAtLevel($this->depth);
    }
}
