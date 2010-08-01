<?php
/**
 * FileLister
 *
 * Copyright 2010 by Shaun McCormick <shaun@modxcms.com>
 *
 * This file is part of FileLister, a file listing Extra.
 *
 * FileLister is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * FileLister is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * FileLister; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package filelister
 */
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
/* name */
function feoSortByNameASC($a,$b) {
    return strcmp($a['filename'], $b['filename']);
}
function feoSortByNameDESC($a,$b) {
    return -1 * strcmp($a['filename'], $b['filename']);
}