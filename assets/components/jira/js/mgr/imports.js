var Imports = function(config) {
    config = config || {};
    Imports.superclass.constructor.call(this,config);
};
Ext.extend(Imports,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('imports',Imports);
Imports = new Imports();