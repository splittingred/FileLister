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
        'desc' => 'prop_feo.path_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'fileTpl',
        'desc' => 'prop_feo.filetpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoFile',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'directoryTpl',
        'desc' => 'prop_feo.directorytpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoDirectory',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'fileLinkTpl',
        'desc' => 'prop_feo.filelinktpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoFileLink',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'dateFormat',
        'desc' => 'prop_feo.dateformat_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '%b %d, %Y',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'cls',
        'desc' => 'prop_feo.cls_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feo-row',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'altCls',
        'desc' => 'prop_feo.altcls_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feo-alt-row',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'firstCls',
        'desc' => 'prop_feo.firstcls_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feo-first-row',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'lastCls',
        'desc' => 'prop_feo.lastcls_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feo-last-row',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'outputSeparator',
        'desc' => 'prop_feo.outputseparator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => "\n",
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'skipDirs',
        'desc' => 'prop_feo.skipdirs_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '.svn,.git,.metadata,.tmp,.DS_Store,_notes',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'placeholderPrefix',
        'desc' => 'prop_feo.placeholderprefix_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'filelister',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'pathSeparator',
        'desc' => 'prop_feo.pathseparator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '/',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'pathTpl',
        'desc' => 'prop_feo.pathtpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'feoPathLink',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'showFiles',
        'desc' => 'prop_feo.showfiles_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'showDirectories',
        'desc' => 'prop_feo.showdirectories_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'showExt',
        'desc' => 'prop_feo.showext_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'sortBy',
        'desc' => 'prop_feo.sortby_desc',
        'type' => 'list',
        'options' => array(
            array('text' => 'feo.filename','value' => 'filename'),
            array('text' => 'feo.date','value' => 'date'),
            array('text' => 'feo.size','value' => 'size'),
            array('text' => 'feo.extension','value' => 'extension'),
        ),
        'value' => 'filename',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'sortDir',
        'desc' => 'prop_feo.sortdir_desc',
        'type' => 'list',
        'options' => array(
            array('text' => 'feo.asc','value' => 'ASC'),
            array('text' => 'feo.desc','value' => 'DESC'),
        ),
        'value' => 'ASC',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'allowDownload',
        'desc' => 'prop_feo.allowdownload_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'requireAuthDownload',
        'desc' => 'prop_feo.requireauthdownload_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => false,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'allowDownloadGroups',
        'desc' => 'prop_feo.allowdownloadgroups_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'showDownloads',
        'desc' => 'prop_feo.showdownloads_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'uniqueDownloads',
        'desc' => 'prop_feo.uniquedownloads_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'useGeolocation',
        'desc' => 'prop_feo.usegeolocation_desc',
        'type' => 'combo-boolean',
        'options' => '',
        'value' => true,
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'prop_feo.toplaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'filelister:properties',
    ),
    array(
        'name' => 'navKey',
        'desc' => 'prop_feo.navkey_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'fd',
        'lexicon' => 'filelister:properties',
    ),
);

return $properties;