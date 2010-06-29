<?php
/**
 * @package fileo
 * @subpackage build
 */
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'Fileo',
    'description' => 'A file listing snippet.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.fileo.php'),
),'',true,true);
$properties = include $sources['properties'].'properties.fileo.php';
$snippets[0]->setProperties($properties);
unset($properties);


return $snippets;