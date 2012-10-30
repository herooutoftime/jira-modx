<?php

$settings = array();

$settings['jira.host']= $modx->newObject('modSystemSetting');
$settings['jira.host']->fromArray(array(
    'key' => 'jira.host',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.user']= $modx->newObject('modSystemSetting');
$settings['jira.user']->fromArray(array(
    'key' => 'jira.user',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.password']= $modx->newObject('modSystemSetting');
$settings['jira.password']->fromArray(array(
    'key' => 'jira.password',
    'value' => '',
    'xtype' => 'textfield',
    'inputType' => 'password',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.detail']= $modx->newObject('modSystemSetting');
$settings['jira.detail']->fromArray(array(
    'key' => 'jira.detail',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.edit']= $modx->newObject('modSystemSetting');
$settings['jira.edit']->fromArray(array(
    'key' => 'jira.edit',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.ajax']= $modx->newObject('modSystemSetting');
$settings['jira.ajax']->fromArray(array(
    'key' => 'jira.ajax',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.modal']= $modx->newObject('modSystemSetting');
$settings['jira.modal']->fromArray(array(
    'key' => 'jira.modal',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_from']= $modx->newObject('modSystemSetting');
$settings['jira.mail_from']->fromArray(array(
    'key' => 'jira.mail_from',
    'value' => 'jira@bundesliga.at',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_from_name']= $modx->newObject('modSystemSetting');
$settings['jira.mail_from_name']->fromArray(array(
    'key' => 'jira.mail_from_name',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_sender']= $modx->newObject('modSystemSetting');
$settings['jira.mail_sender']->fromArray(array(
    'key' => 'jira.mail_sender',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_to']= $modx->newObject('modSystemSetting');
$settings['jira.mail_to']->fromArray(array(
    'key' => 'jira.mail_to',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_reply_to']= $modx->newObject('modSystemSetting');
$settings['jira.mail_reply_to']->fromArray(array(
    'key' => 'jira.mail_reply_to',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_html']= $modx->newObject('modSystemSetting');
$settings['jira.mail_html']->fromArray(array(
    'key' => 'jira.mail_html',
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.mail_chunk']= $modx->newObject('modSystemSetting');
$settings['jira.mail_chunk']->fromArray(array(
    'key' => 'jira.mail_chunk',
    'value' => 'jira_email',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.modx_users']= $modx->newObject('modSystemSetting');
$settings['jira.modx_users']->fromArray(array(
    'key' => 'jira.modx_users',
    'value' => '',
    'description' => 'Comma-separated list of MODx users to be identified',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.project']= $modx->newObject('modSystemSetting');
$settings['jira.project']->fromArray(array(
    'key' => 'jira.project',
    'value' => '',
    'description' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

$settings['jira.issuetypes']= $modx->newObject('modSystemSetting');
$settings['jira.issuetypes']->fromArray(array(
    'key' => 'jira.issuetypes',
    'value' => '',
    'description' => '',
    'xtype' => 'textfield',
    'namespace' => 'jira',
    'area' => 'system',
),'',true,true);

return $settings;