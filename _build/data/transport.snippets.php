<?php
/**
 * @package filelister
 * @subpackage build
 */
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'FileLister',
    'description' => 'A file listing snippet.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.filelister.php'),
),'',true,true);
$properties = include $sources['properties'].'properties.filelister.php';
$snippets[0]->setProperties($properties);
unset($properties);


return $snippets;