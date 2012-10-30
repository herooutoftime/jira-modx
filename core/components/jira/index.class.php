<?php
require_once dirname(__FILE__) . '/model/imports/imports.class.php';
abstract class ImportsManagerController extends modExtraManagerController {
    /** @var Imports $imports */
    public $imports;
    public function initialize() {
        $this->imports = new Imports($this->modx);
 
        //$this->addCss($this->imports->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->imports->config['jsUrl'].'mgr/imports.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Imports.config = '.$this->modx->toJSON($this->imports->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('imports:default');
    }
    public function checkPermissions() { return true;}
}
class IndexManagerController extends ImportsManagerController {
    public static function getDefaultController() { return 'home'; }
}