Ext.onReady(function() {
    MODx.load({ xtype: 'imports-page-home'});
});
 
Imports.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'imports-panel-home'
            ,renderTo: 'imports-panel-home-div'
        }]
    });
    Imports.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(Imports.page.Home,MODx.Component);
Ext.reg('imports-page-home',Imports.page.Home);