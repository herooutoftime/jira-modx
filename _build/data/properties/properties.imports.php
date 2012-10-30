<?php
$properties = array(
    array(
        'name' => 'tpl',
        'desc' => 'prop_imports.tpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'rowTpl',
        'lexicon' => 'imports:properties',
    ),
    array(
        'name' => 'sort',
        'desc' => 'prop_imports.sort_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'name',
        'lexicon' => 'imports:properties',
    ),
    array(
        'name' => 'dir',
        'desc' => 'prop_imports.dir_desc',
        'type' => 'list',
        'options' => array(
            array('text' => 'prop_imports.ascending','value' => 'ASC'),
            array('text' => 'prop_imports.descending','value' => 'DESC'),
        ),
        'value' => 'DESC',
        'lexicon' => 'imports:properties',
    ),
);
return $properties;