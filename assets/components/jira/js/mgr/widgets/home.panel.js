Imports.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('imports.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('imports')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('imports.management_desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'imports-grid-imports'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }]
        }]
    });
    Imports.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Imports.panel.Home,MODx.Panel);
Ext.reg('imports-panel-home',Imports.panel.Home);