<?php
/**
 * Sort algorithms for file sorting
 * 
 * @package filelister
 */
/* extension */
function feoSortByExtensionASC($a,$b) {
    return strcmp($a['extension'], $b['extension']);
}
function feoSortByExtensionDESC($a,$b) {
    return -1 * strcmp($a['extension'], $b['extension']);
}
/* lastmod */
function feoSortByLastModifiedASC($a,$b) {
    return strcmp($a['lastmod'], $b['lastmod']);
}
function feoSortByLastModifiedDESC($a,$b) {
    return -1 * strcmp($a['lastmod'], $b['lastmod']);
}
/* size */
function feoSortBySizeASC($a,$b) {
    return $a['bytesize'] > $b['bytesize'];
}
function feoSortBySizeDESC($a,$b) {
    return $a['bytesize'] < $b['bytesize'];
}