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
 * File listing snippet
 *
 * @var modX $modx
 * @var FileLister $fileLister
 * @var array $scriptProperties
 * 
 * @package filelister
 */
$fileLister = $modx->getService('filelister','FileLister',$modx->getOption('filelister.core_path',null,$modx->getOption('core_path').'components/filelister/').'model/filelister/',$scriptProperties);
if (!($fileLister instanceof FileLister)) return '';

/* get path */
$path = $modx->getOption('path',$scriptProperties,false);
$fileLister->sanitize($path);
if (empty($path) || !is_dir($path)) return '';

/* setup default properties */
$fileTpl = $modx->getOption('fileTpl',$scriptProperties,'feoFile');
$fileLinkTpl = $modx->getOption('fileLinkTpl',$scriptProperties,'feoFileLink');
$directoryTpl = $modx->getOption('directoryTpl',$scriptProperties,'feoDirectory');
$dateFormat = $modx->getOption('dateFormat',$scriptProperties,'%b %d, %Y');
$skipDirs = $modx->getOption('skipDirs',$scriptProperties,'.svn,.git,.metadata,.tmp,.DS_Store,_notes');
$skipDirs = array_merge(array('.','..'),explode(',',$skipDirs));
$placeholderPrefix = $modx->getOption('placeholderPrefix',$scriptProperties,'filelister');
$pathSeparator = $modx->getOption('pathSeparator',$scriptProperties,'/');
$pathTpl = $modx->getOption('pathTpl',$scriptProperties,'feoPathLink');
$navKey = $modx->getOption('navKey',$scriptProperties,'fd');
$showFiles = (boolean)$modx->getOption('showFiles',$scriptProperties,true);
$showDirectories = (boolean)$modx->getOption('showDirectories',$scriptProperties,true);
$showExt = $modx->getOption('showExt',$scriptProperties,'');
if (!empty($showExt)) $showExt = explode(',',$showExt);
$showDownloads = (boolean)$modx->getOption('showDownloads',$scriptProperties,true);
$uniqueDownloads = (boolean)$modx->getOption('uniqueDownloads',$scriptProperties,true);
$useGeolocation = (boolean)$modx->getOption('useGeolocation',$scriptProperties,true);
$limit = (int)$modx->getOption('limit',$scriptProperties,0);
$cls = $modx->getOption('cls',$scriptProperties,'feo-row');
$altCls = $modx->getOption('altCls',$scriptProperties,'feo-alt-row');
$firstCls = $modx->getOption('firstCls',$scriptProperties,'feo-first-row');
$lastCls = $modx->getOption('lastCls',$scriptProperties,'feo-last-row');

/* get relPath and curPath */
$fd = $modx->getOption($navKey,$_REQUEST,false);
$relPath = '';
if ($fd) {
    $relPath = $fileLister->parseKey($fd);
    if ($relPath == '.') $relPath = '';
}
$curPath = $fileLister->sanitize($path.$relPath);

/* if pointing to file, output file */
if (!is_dir($curPath) && is_file($curPath)) {
    /* do download tracking and geolocation */
    $tenMinAgo = time() - (60 * 5); /* prevent duplicate download tracking */
    $tenMinAgo = strftime('%Y-%m-%d %H:%M:%S',$tenMinAgo);
    $double = $modx->getCount('feoDownload',array(
        'path' => $curPath,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'downloadedon:>' => $tenMinAgo,
    ));
    if ($double <= 0) {
        $unique = $modx->getCount('feoDownload',array(
            'path' => $curPath,
            'ip' => $_SERVER['REMOTE_ADDR'],
        ));

        /** @var feoDownload $dl */
        $dl = $modx->newObject('feoDownload');
        $dl->set('path',$curPath);
        $dl->set('ip',$_SERVER['REMOTE_ADDR']);
        $dl->set('downloadedon',strftime('%Y-%m-%d %H:%M:%S'));
        $dl->set('unique',$unique > 0 ? false : true);
        $dl->set('referer',$_SERVER['HTTP_REFERER']);

        $geoApiKey = $modx->getOption('filelister.ipinfodb_api_key',$scriptProperties,'');
        if ($useGeolocation && !empty($geoApiKey)) {
            $modx->loadClass('geolocation.ipinfodb',$fileLister->config['modelPath'],true,true);
            $geo = new ipinfodb($modx);
            $geo->setKey($geoApiKey);
            $locations = $geo->getGeoLocation($_SERVER['REMOTE_ADDR']);
            $geolocation = array();
            if (!empty($locations[0]) && is_array($locations[0])) {
                $gl = $locations[0];
                $dl->set('geolocation',$gl);
                $dl->set('country',$gl['CountryCode']);
                $dl->set('region',$gl['RegionName']);
                $dl->set('city',$gl['City']);
                $dl->set('zip',$gl['ZipPostalCode']);
            }
            if ($modx->user->hasSessionContext($modx->context->get('key'))) {
                $dl->set('user',$modx->user->get('id'));
            }
        }
        $dl->save();

    }

    $fileLister->loadHeaders($curPath);
    $fileLister->renderFile($curPath);
    die();
} elseif (!is_dir($curPath)) {
    /* if an invalid path, set to base */
    $curPath = $path;
}

/* check download access */
$allowDownloadGroups = $modx->getOption('allowDownloadGroups',$scriptProperties,'');
if (!empty($allowDownloadGroups)) $allowDownloadGroups = explode(',',$allowDownloadGroups);

$canDownload = $modx->getOption('allowDownload',$scriptProperties,true);
if ($modx->getOption('requireAuthDownload',$scriptProperties,false)) {
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
$totalDownloads = 0;
$directories = array();
$files = array();
/** @var DirectoryIterator $file */
foreach (new DirectoryIterator($curPath) as $file) {
    if (in_array($file,$skipDirs)) continue;
    if (!$file->isReadable()) continue;

    /* make the key that is used for navigation */
    $filePath = $file->getPathname();
    $filePath = $relPath.(!empty($relPath) ? '/' : '').$file->getFilename();
    $key = $fileLister->makeKey($filePath);

    $fileArray = array();
    $fileArray['filename'] = $file->getFilename();
    $fileArray['bytesize'] = $file->getSize();
    $fileArray['filesize'] = $fileLister->formatBytes($file->getSize());
    $fileArray['path'] = str_replace('\\', '/', $file->getPathname());
    $fileArray['relativePath'] = $filePath;
    $fileArray['navKey'] = $navKey;
    $fileArray['showDownloads'] = $showDownloads;

    /* if allowing for downloading, generate a link here */
    if ($file->isDir() || $canDownload) {
        $fileArray['link'] = $fileLister->getChunk($fileLinkTpl,array(
            'url' => $modx->makeUrl($modx->resource->get('id'),'',array(
                $navKey => $key,
            )),
            'filename' => $fileArray['filename'],
        ));
    } else {
        $fileArray['link'] = $fileArray['filename'];
    }
    /* if resource is a file */
    if ($file->isFile() && $showFiles) {
        $fileArray['extension'] = pathinfo($fileArray['path'],PATHINFO_EXTENSION);
        if (!empty($showExt) && !in_array($fileArray['extension'],$showExt)) continue;
        
        $fileArray['lastmod'] = $file->getMTime();
        $fileArray['dateFormat'] = $dateFormat;

        /* get download count for file */
        if ($showDownloads) {
            $w = array('path' => $fileArray['path']);
            if ($uniqueDownloads) $w['unique'] = true;
            $fileArray['downloads'] = $modx->getCount('feoDownload',$w);
            $totalDownloads += (int)$fileArray['downloads'];
        }

        $files[] = $fileArray;
        $fileCount++;
        
    /* else if resource is a directory */
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
include_once $fileLister->config['includesPath'].'sort.algorithms.php';
$algo = '';
switch ($sortBy.'-'.$sortDir) {
    case 'filename-ASC': case 'name-ASC': $algo = 'feoSortByNameASC'; break;
    case 'filename-DESC': case 'name-DESC': $algo = 'feoSortByNameDESC'; break;
    case 'extension-ASC': $algo = 'feoSortByExtensionASC'; break;
    case 'extension-DESC': $algo = 'feoSortByExtensionDESC'; break;
    case 'date-ASC': case 'lastmod-ASC': $algo = 'feoSortByLastModifiedASC'; break;
    case 'date-DESC': case 'lastmod-DESC': $algo = 'feoSortByLastModifiedDESC'; break;
    case 'size-ASC': $algo = 'feoSortBySizeASC'; break;
    case 'size-DESC': $algo = 'feoSortBySizeDESC'; break;
}
if (!empty($algo)) { uasort($files,$algo); }
unset($algo,$sortBy,$sortDir);

/* get templated chunks for each fs resource */
$i = 0;
$totalCount = count($directories) + count($files);
if ($totalCount > $limit) $totalCount = $limit; /* getPage compat */
foreach ($directories as $directory) {
    $odd = $i % 2;
    $directory['cls'] = $odd ? $altCls : $cls;
    if ($i == 0) $directory['cls'] .= ' '.$firstCls;
    if ($i == ($totalCount-1)) $directory['cls'] .= ' '.$lastCls;
    $list[] = $fileLister->getChunk($directoryTpl,$directory);
    $i++;
}
unset($directory);
foreach ($files as $file) {
    $odd = $i % 2;
    $file['cls'] = $odd ? $altCls : $cls;
    if ($i == 0) $file['cls'] .= ' '.$firstCls;
    if ($i == ($totalCount-1)) $file['cls'] .= ' '.$lastCls;
    $list[] = $fileLister->getChunk($fileTpl,$file);
    $i++;
}
unset($file);

/* set placeholders */
$homePathName = $modx->getOption('homePathName',$scriptProperties,'');
if (!empty($homePathName)) {
    $path = $homePathName;
}
$placeholders = array(
    'total' => $count,
    'total.files' => $fileCount,
    'total.directories' => $directoryCount,
    'total.downloads' => $totalDownloads,
    'path' => $fileLister->parsePathIntoLinks($relPath,$path,$pathTpl,$pathSeparator,$navKey),
    'relativePath' => $relPath,
);
$modx->toPlaceholders($placeholders,$placeholderPrefix);

/* output */
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,'');
if (count($list) > 0) {
    /* pagination handling in conjunction with getPage */
    if (!empty($limit)) {
        $pageVarKey = $modx->getOption('pageVarKey',$scriptProperties,'page');
        $page = (int)$modx->getOption($pageVarKey,$scriptProperties,$modx->getOption($pageVarKey,$_REQUEST,1));
        $offset = (int)$modx->getOption('offset',$scriptProperties,0);
        /* cut the list of file into blocks */
        $list = array_chunk($list,$limit,true);
        /* output the current listing block */
        $output = implode($outputSeparator,$list[$page - 1]);
        /* need to make the total available without placeholder prefix for getPage */
        $modx->setPlaceholder('total',$count);
    } else {
        /* no pagination so display all results */
        $output = implode($outputSeparator,$list);
    }
} else {
  /* empty directory so display nothing */
  $output = '';
}
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if ($toPlaceholder) {
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}
return $output;