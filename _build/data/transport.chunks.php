<?php
$chunks = array();

$chunks[0]= $modx->newObject('modChunk');
$chunks[0]->fromArray(array(
    'id' => 0,
    'name' => 'jira_attachment',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_attachment.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_attachment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'jira_comment',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_comment.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'jira_commentform',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_commentform.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 1,
    'name' => 'jira_detail',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_detail.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[4]= $modx->newObject('modChunk');
$chunks[4]->fromArray(array(
    'id' => 4,
    'name' => 'jira_email',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_email.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[5]= $modx->newObject('modChunk');
$chunks[5]->fromArray(array(
    'id' => 5,
    'name' => 'jira_error',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_error.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[6]= $modx->newObject('modChunk');
$chunks[6]->fromArray(array(
    'id' => 6,
    'name' => 'jira_filter',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_filter.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[7]= $modx->newObject('modChunk');
$chunks[7]->fromArray(array(
    'id' => 7,
    'name' => 'jira_item',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_item.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[8]= $modx->newObject('modChunk');
$chunks[8]->fromArray(array(
    'id' => 8,
    'name' => 'jira_legend',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_legend.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[9]= $modx->newObject('modChunk');
$chunks[9]->fromArray(array(
    'id' => 9,
    'name' => 'jira_modal',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_modal.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[10]= $modx->newObject('modChunk');
$chunks[10]->fromArray(array(
    'id' => 10,
    'name' => 'jira_subitem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_subitem.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[10]= $modx->newObject('modChunk');
$chunks[10]->fromArray(array(
    'id' => 10,
    'name' => 'jira_subitem',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_subitem.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[11]= $modx->newObject('modChunk');
$chunks[11]->fromArray(array(
    'id' => 11,
    'name' => 'jira_watchers',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_watchers.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

$chunks[12]= $modx->newObject('modChunk');
$chunks[12]->fromArray(array(
    'id' => 12,
    'name' => 'jira_form',
    'description' => '',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/jira_form.tpl.html'),
    'properties' => '',
    //'static' => 1,
    //'static_file' => $sources['source_core'].'/elements/chunks/jira_comment.tpl.html',
    //'source' => 1,
),'',true,true);

return $chunks;