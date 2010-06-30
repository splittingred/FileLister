<?php
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