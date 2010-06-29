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
$fileo->sanitize($path);
if (empty($path) || !is_dir($path)) return '';

/* setup default properties */
$fileTpl = $modx->getOption('fileTpl',$scriptProperties,'feoFile');
$directoryTpl = $modx->getOption('directoryTpl',$scriptProperties,'feoDirectory');
$upTpl = $modx->getOption('upTpl',$scriptProperties,'feoUp');
$showUp = $modx->getOption('showUp',$scriptProperties,true);
$fd = $modx->getOption('fd',$_REQUEST,false);

/* get dynpath */
$dynPath = '';
if ($fd) {
    $dynPath = $fileo->parseKey($fd);
    if ($dynPath == '.') $dynPath = '';
}

/* iterate across files */
$files = array();
if (!empty($dynPath) && $dynPath != '/' && $showUp) {
    $up = dirname($dynPath);
    $p = '';
    if ($up != $path) {
        $key = $fileo->makeKey($up);
        $p = array('fd' => $key);
    }
    $files[] = $fileo->getChunk($upTpl,array(
        'url' => $modx->makeUrl($modx->resource->get('id'),'',$p),
    ));
}
$curPath = $fileo->sanitize($path.$dynPath);


if (!is_dir($curPath)) {
    /* process as file */
    $fileo->loadHeaders($curPath);
    $o = file_get_contents($curPath);
    echo $o;
    die();
}

$count = 0;
foreach (new DirectoryIterator($curPath) as $file) {
    if (in_array($file,array('.','..','.svn','.DS_Store','_notes'))) continue;
    if (!$file->isReadable()) continue;

    $filePath = $file->getPathname();
    $filePath = $dynPath.'/'.$file->getFilename();
    $key = $fileo->makeKey($filePath);

    $fileArray = array();
    $fileArray['filename'] = $file->getFilename();
    $fileArray['filesize'] = $file->getSize();
    $fileArray['path'] = $file->getPathname();
    $fileArray['dynPath'] = $filePath;

    $fileArray['url'] = $modx->makeUrl($modx->resource->get('id'),'',array(
        'fd' => $key,
    ));
    if ($file->isFile()) {
        $files[] = $fileo->getChunk($fileTpl,$fileArray);
    } elseif ($file->isDir()) {
        $files[] = $fileo->getChunk($directoryTpl,$fileArray);
    }
    $count++;
}

$modx->setPlaceholder('fileo.total',$count);
$modx->setPlaceholder('fileo.path',$curPath);

/* output */
$output = implode("\n",$files);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if ($toPlaceholder) {
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}
return $output;