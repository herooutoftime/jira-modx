<?php
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$snippets = array();
 
$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'jira',
    'description' => 'Base snippet for JIRA ticketing.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.jira.php'),
),'',true,true);
$properties = include $sources['data'].'properties/properties.imports.php';
$snippets[1]->setProperties($properties);
unset($properties);
 
return $snippets;