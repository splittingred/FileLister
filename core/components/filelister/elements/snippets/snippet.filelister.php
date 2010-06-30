<?php
/**
 * File listing snippet
 * 
 * @package filelister
 */
$filelister = $modx->getService('filelister','FileLister',$modx->getOption('filelister.core_path',null,$modx->getOption('core_path').'components/filelister/').'model/filelister/',$scriptProperties);
if (!($filelister instanceof filelister)) return '';

/* get path */
$path = $modx->getOption('path',$scriptProperties,false);
$filelister->sanitize($path);
if (empty($path) || !is_dir($path)) return '';

/* setup default properties */
$fileTpl = $modx->getOption('fileTpl',$scriptProperties,'feoFile');
$directoryTpl = $modx->getOption('directoryTpl',$scriptProperties,'feoDirectory');
$upTpl = $modx->getOption('upTpl',$scriptProperties,'feoUp');
$showUp = $modx->getOption('showUp',$scriptProperties,true);
$dateFormat = $modx->getOption('dateFormat',$scriptProperties,'%b %d, %Y');
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");
$skipDirs = $modx->getOption('skipDirs',$scriptProperties,'.,..,.svn,.git,.metadata,.tmp,.DS_Store,_notes');
$skipDirs = explode(',',$skipDirs);
$placeholderPrefix = $modx->getOption('placeholderPrefix',$scriptProperties,'filelister');
$pathSeparator = $modx->getOption('pathSeparator',$scriptProperties,'/');
$pathTpl = $modx->getOption('pathTpl',$scriptProperties,'feoPathLink');

/* get dynpath */
$fd = $modx->getOption('fd',$_REQUEST,false);
$dynPath = '';
if ($fd) {
    $dynPath = $filelister->parseKey($fd);
    if ($dynPath == '.') $dynPath = '';
}


$curPath = $filelister->sanitize($path.$dynPath);

/* if pointing to file, output file */
if (!is_dir($curPath)) {
    $filelister->loadHeaders($curPath);
    $o = file_get_contents($curPath);
    echo $o;
    die();
}

/* iterate list of files/dirs */
$count = 0;
$directoryCount = 0;
$fileCount = 0;
$directories = array();
$files = array();
foreach (new DirectoryIterator($curPath) as $file) {
    if (in_array($file,$skipDirs)) continue;
    if (!$file->isReadable()) continue;

    $filePath = $file->getPathname();
    $filePath = $dynPath.(!empty($dynPath) ? '/' : '').$file->getFilename();
    $key = $filelister->makeKey($filePath);

    $fileArray = array();
    $fileArray['filename'] = $file->getFilename();
    $fileArray['filesize'] = $filelister->formatBytes($file->getSize());
    $fileArray['path'] = $file->getPathname();
    $fileArray['dynPath'] = $filePath;

    $fileArray['url'] = $modx->makeUrl($modx->resource->get('id'),'',array(
        'fd' => $key,
    ));
    if ($file->isFile()) {
        $fileArray['lastmod'] = $file->getMTime();
        $fileArray['dateFormat'] = $dateFormat;
        $files[] = $filelister->getChunk($fileTpl,$fileArray);
        $fileCount++;
    } elseif ($file->isDir()) {
        $directories[] = $filelister->getChunk($directoryTpl,$fileArray);
        $directoryCount++;
    }
    $count++;
}


$up = false;
if (!empty($dynPath) && $dynPath != '/' && $showUp) {
    $up = dirname($dynPath);
    $p = '';
    if ($up != $path) {
        $key = $filelister->makeKey($up);
        $p = array('fd' => $key);
    }
    $up = $filelister->getChunk($upTpl,array(
        'url' => $modx->makeUrl($modx->resource->get('id'),'',$p),
    ));
}
$list = array_merge($directories,$files);

/* set placeholders */
$placeholders = array(
    'total' => $count,
    'total.files' => $fileCount,
    'total.directories' => $directoryCount,
    'path' => $filelister->parsePathIntoLinks($dynPath,$path,$pathTpl,$pathSeparator),
    'dynPath' => $dynPath,
);
$modx->toPlaceholders($placeholders,$placeholderPrefix);

/* output */
$output = implode($outputSeparator,$list);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if ($toPlaceholder) {
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}
return $output;