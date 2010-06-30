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
        'name' => 'fileTpl',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoFile',
    ),
    array(
        'name' => 'directoryTpl',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoDirectory',
    ),
    array(
        'name' => 'fileLinkTpl',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoFileLink',
    ),
    array(
        'name' => 'dateFormat',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => '%b %d, %Y',
    ),
    array(
        'name' => 'outputSeparator',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => "\n",
    ),
    array(
        'name' => 'skipDirs',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => '.,..,.svn,.git,.metadata,.tmp,.DS_Store,_notes',
    ),
    array(
        'name' => 'placeholderPrefix',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => 'filelister',
    ),
    array(
        'name' => 'pathSeparator',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => '/',
    ),
    array(
        'name' => 'pathTpl',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoPathLink',
    ),
    array(
        'name' => 'showFiles',
        'desc' => '',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showDirectories',
        'desc' => '',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'showExt',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'sortBy',
        'desc' => '',
        'type' => 'list',
        'options' => array(
            array('text' => 'File Name','value' => 'filename'),
            array('text' => 'Date','value' => 'date'),
            array('text' => 'Size','value' => 'size'),
            array('text' => 'Extension','value' => 'extension'),
        ),
        'value' => '',
    ),
    array(
        'name' => 'sortDir',
        'desc' => '',
        'type' => 'list',
        'options' => array(
            array('text' => 'DESC','value' => 'ASC'),
            array('text' => 'DESC','value' => 'ASC'),
        ),
        'value' => '',
    ),
    array(
        'name' => 'allowDownload',
        'desc' => '',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
    ),
    array(
        'name' => 'requireAuthDownload',
        'desc' => '',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
    ),
    array(
        'name' => 'allowDownloadGroups',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
    ),
    array(
        'name' => 'navKey',
        'desc' => '',
        'type' => 'textfield',
        'options' => '',
        'value' => 'fd',
    ),
);

return $properties;