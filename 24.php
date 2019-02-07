<?php
require 'libs/FullKaryTree.php';
/**
 * simulating:
 * for ($i = 1; $i <= 4; $i++) {
 *  for ($j = 1; $j <=4; $j++) {
 *      for ($k = 1; $k <=4; $k++) {
 *          for ($l = 1; $l <= 4; $l ++) {
 *
 *          }
 *      }
 *  }
 * }
 */
$tree = new FullKaryTree(4, 4,[
    function($node) {
        return !isset($node['parent']['pathHash'][$node['value']]);
    }
]);

print_r($tree->getPathsAtLevel(4));
