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
$fileLinkTpl = $modx->getOption('fileLinkTpl',$scriptProperties,'feoFileLink');
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
$navKey = $modx->getOption('navKey',$scriptProperties,'fd');
$showFiles = $modx->getOption('showFiles',$scriptProperties,true);
$showDirectories = $modx->getOption('showDirectories',$scriptProperties,true);
$showExt = $modx->getOption('showExt',$scriptProperties,'');
if (!empty($showExt)) $showExt = explode(',',$showExt);

/* get relPath and curPath */
$fd = $modx->getOption($navKey,$_REQUEST,false);
$relPath = '';
if ($fd) {
    $relPath = $filelister->parseKey($fd);
    if ($relPath == '.') $relPath = '';
}
$curPath = $filelister->sanitize($path.$relPath);

/* if pointing to file, output file */
if (!is_dir($curPath) && is_file($curPath)) {
    $filelister->loadHeaders($curPath);
    $o = file_get_contents($curPath);
    echo $o;
    die();
} elseif (!is_dir($curPath)) {
    /* if an invalid path, set to base */
    $curPath = $path;
}

/* check download access */
$allowDownloadGroups = $modx->getOption('allowDownloadGroups',$scriptProperties,'');
if (!empty($allowDownloadGroups)) $allowDownloadGroups = explode(',',$allowDownloadGroups);

$canDownload = $modx->getOption('allowDownload',$scriptProperties,false);
if ($modx->getOption('requireAuthDownload',$scriptProperties,true)) {
    $requireAuthContext = $modx->getOption('requireAuthContext',$scriptProperties,$modx->context->get('key'));
    $canDownload = $modx->user->hasSessionContext($requireAuthContext);
}
if (!empty($allowDownloadGroups)) {
    $canDownload = $modx->user->isMember($allowDownloadGroups);
}
unset($requireAuthContext,$allowDownloadGroups);

/* iterate list of files/dirs */
$count = 0;
$directoryCount = 0;
$fileCount = 0;
$directories = array();
$files = array();
foreach (new DirectoryIterator($curPath) as $file) {
    if (in_array($file,$skipDirs)) continue;
    if (!$file->isReadable()) continue;

    /* make the key that is used for navigation */
    $filePath = $file->getPathname();
    $filePath = $relPath.(!empty($relPath) ? '/' : '').$file->getFilename();
    $key = $filelister->makeKey($filePath);

    $fileArray = array();
    $fileArray['filename'] = $file->getFilename();
    $fileArray['bytesize'] = $file->getSize();
    $fileArray['filesize'] = $filelister->formatBytes($file->getSize());
    $fileArray['path'] = $file->getPathname();
    $fileArray['relativePath'] = $filePath;
    $fileArray['navKey'] = $navKey;
    if ($file->isDir() || $canDownload) {
        $fileArray['link'] = $filelister->getChunk($fileLinkTpl,array(
            'url' => $modx->makeUrl($modx->resource->get('id'),'',array(
                $navKey => $key,
            )),
            'filename' => $fileArray['filename'],
        ));
    } else {
        $fileArray['link'] = $fileArray['filename'];
    }
    if ($file->isFile() && $showFiles) {
        $fileArray['extension'] = pathinfo($fileArray['path'],PATHINFO_EXTENSION);
        if (!empty($showExt) && !in_array($fileArray['extension'],$showExt)) continue;
        
        $fileArray['lastmod'] = $file->getMTime();
        $fileArray['dateFormat'] = $dateFormat;
        $files[] = $fileArray;
        $fileCount++;
    } elseif ($file->isDir() && $showDirectories) {
        $directories[] = $fileArray;
        $directoryCount++;
    }
    $count++;
}
unset($fileArray,$file);


/* do sorting on files */
$sortBy = $modx->getOption('sortBy',$scriptProperties,'size');
$sortDir = $modx->getOption('sortDir',$scriptProperties,'ASC');
include_once $filelister->config['includesPath'].'sort.algorithms.php';
$algo = '';
switch ($sortBy.'-'.$sortDir) {
    case 'extension-ASC': $algo = 'feoSortByExtensionASC'; break;
    case 'extension-DESC': $algo = 'feoSortByExtensionDESC'; break;
    case 'date-ASC': case 'lastmod-ASC': $algo = 'feoSortByLastModifiedASC'; break;
    case 'date-DESC': case 'lastmod-DESC': $algo = 'feoSortByLastModifiedDESC'; break;
    case 'size-ASC': $algo = 'feoSortBySizeASC'; break;
    case 'size-DESC': $algo = 'feoSortBySizeDESC'; break;
}
if (!empty($algo)) { uasort($files,$algo); }
unset($algo,$sortBy,$sortDir);

foreach ($directories as $directory) {
    $list[] = $filelister->getChunk($directoryTpl,$directory);
}
foreach ($files as $file) {
    $list[] = $filelister->getChunk($fileTpl,$file);
}


$up = false;
if (!empty($relPath) && $relPath != '/' && $showUp) {
    $up = dirname($relPath);
    $p = '';
    if ($up != $path) {
        $key = $filelister->makeKey($up);
        $p = array('fd' => $key);
    }
    $up = $filelister->getChunk($upTpl,array(
        'url' => $modx->makeUrl($modx->resource->get('id'),'',$p),
    ));
}

/* set placeholders */
$placeholders = array(
    'total' => $count,
    'total.files' => $fileCount,
    'total.directories' => $directoryCount,
    'path' => $filelister->parsePathIntoLinks($relPath,$path,$pathTpl,$pathSeparator,$navKey),
    'relativePath' => $relPath,
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