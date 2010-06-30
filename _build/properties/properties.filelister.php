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
 * Default properties for FileLister snippet
 *
 * @package filelister
 * @subpackage build
 */
$properties = array(
    array(
        'name' => 'path',
        'desc' => 'The path to browse from.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'fileTpl',
        'desc' => 'The chunk for each file listing.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoFile',
    ),
    array(
        'name' => 'directoryTpl',
        'desc' => 'The chunk for each directory listing.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoDirectory',
    ),
    array(
        'name' => 'fileLinkTpl',
        'desc' => 'The chunk for the links for each listing.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoFileLink',
    ),
    array(
        'name' => 'dateFormat',
        'desc' => 'A PHP date format for the last modified field.',
        'type' => 'textfield',
        'options' => '',
        'value' => '%b %d, %Y',
    ),
    array(
        'name' => 'outputSeparator',
        'desc' => 'A separator that is appended to each listing.',
        'type' => 'textfield',
        'options' => '',
        'value' => "\n",
    ),
    array(
        'name' => 'skipDirs',
        'desc' => 'A comma-separated list of directory names to always skip.',
        'type' => 'textfield',
        'options' => '',
        'value' => '.svn,.git,.metadata,.tmp,.DS_Store,_notes',
    ),
    array(
        'name' => 'placeholderPrefix',
        'desc' => 'The prefix to append to all global placeholders set by the snippet.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'filelister',
    ),
    array(
        'name' => 'pathSeparator',
        'desc' => 'The separator between items generated in the +path placeholder.',
        'type' => 'textfield',
        'options' => '',
        'value' => '/',
    ),
    array(
        'name' => 'pathTpl',
        'desc' => 'The chunk for each item in the +path placeholder.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoPathLink',
    ),
    array(
        'name' => 'showFiles',
        'desc' => 'If false, will hide any files from the listing.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showDirectories',
        'desc' => 'If false, will hide any directories from the listing.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showExt',
        'desc' => 'A comma-separated list of extensions to restrict output of files to. If blank, all files will be shown. If any are specified, only files with those extensions will be shown.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'The metric to sort by for each file.',
        'type' => 'list',
        'options' => array(
            array('text' => 'File Name','value' => 'filename'),
            array('text' => 'Date','value' => 'date'),
            array('text' => 'Size','value' => 'size'),
            array('text' => 'Extension','value' => 'extension'),
        ),
        'value' => 'filename',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'The direction to sort by for each file.',
        'type' => 'list',
        'options' => array(
            array('text' => 'DESC','value' => 'ASC'),
            array('text' => 'DESC','value' => 'ASC'),
        ),
        'value' => 'ASC',
    ),
    array(
        'name' => 'allowDownload',
        'desc' => 'If false, will disable viewing and downloads of any files.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'requireAuthDownload',
        'desc' => 'If true, will require users be logged in to view or download a file.',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'allowDownloadGroups',
        'desc' => 'A comma-separated list that, if set, will restrict file viewing/downloading to users in the specified groups.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'If set, will set the output to a placeholder with the specified name rather than directly outputting it.',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'navKey',
        'desc' => 'The REQUEST navigation key used for the browsing.',
        'type' => 'textfield',
        'options' => '',
        'value' => 'fd',
    ),
);

return $properties;