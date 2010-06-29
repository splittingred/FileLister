<?php
/**
 * File listing snippet
 * 
 * @package fileo
 */
$fileo = $modx->getService('fileo','Fileo',$modx->getOption('fileo.core_path',null,$modx->getOption('core_path').'components/fileo/').'model/fileo/',$scriptProperties);
if (!($fileo instanceof Fileo)) return '';

/* get path */
$path = $modx->getOption('path',$scriptProperties,false);
$path = $modx->sanitize($path);
$path = $modx->stripTags($path);
if (empty($path) || !is_dir($path)) return '';

/* setup default properties */
$fileTpl = $modx->getOption('fileTpl',$scriptProperties,'feoFile');

/* iterate across files */
$files = array();
foreach (new DirectoryIterator($path) as $file) {
    if (in_array($file,array('.','..','.svn','.DS_Store','_notes'))) continue;
    if (!$file->isReadable()) continue;

    $fileArray = array();
    $fileArray['filename'] = $file->getFilename();
    $fileArray['filesize'] = $file->getSize();
    if ($file->isFile()) {
    }

    $files[] = $fileo->getChunk($fileTpl,$fileArray);
}

/* output */
$output = implode("\n",$files);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if ($toPlaceholder) {
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}
return $output;