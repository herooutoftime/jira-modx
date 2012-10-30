Imports.grid.Imports = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'imports-grid-imports'
        ,url: Imports.config.connectorUrl
        ,baseParams: { action: 'mgr/import/getList' }
        ,fields: ['id','season','league','round','game','home','away','type','resource','menu','createdon']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'createdon'
        ,save_action: 'mgr/import/updateFromGrid'
        ,autosave: true
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 35
        },{
            header: _('imports.type')
            ,dataIndex: 'type'
            ,sortable: true            
            ,width: 60
            ,editor: {
                xtype: 'modx-combo'
                ,store: [
                    ['video', 'Video'],
                    ['audio', 'OnEar Stream'],
                    ['prereport','Vorbericht'],
                    ['postreport','Nachbericht']
                ]
            }
        },{
            header: _('imports.resource')
            ,dataIndex: 'resource'
            ,sortable: true
            ,width: 60
            ,editor: { xtype: 'textfield' }
        },{
            header: _('imports.season')
            ,dataIndex: 'season'
            ,sortable: true
            ,width: 60
            ,editor: { xtype: 'textfield' }
        },{
            header: _('imports.league')
            ,dataIndex: 'league'
            ,sortable: true
            ,width: 60
            ,editor: {
                xtype: 'modx-combo'
                ,store: [
                    ['BL1', 'BL1'],
                    ['BL2', 'BL2']
                ]    
            }
        },{
            header: _('imports.round')
            ,dataIndex: 'round'
            ,sortable: true
            ,width: 40
            ,editor: { xtype: 'textfield' }
        },{
            header: _('imports.game')
            ,dataIndex: 'game'
            ,sortable: true
            ,width: 40
            ,editor: {
                xtype: 'modx-combo'
                ,store: [
                    [1, '1'],
                    [2, '2'],
                    [3, '3'],
                    [4, '4'],
                    [5, '5']
                ]    
            }
        },{
            header: _('imports.home')
            ,dataIndex: 'home'
            ,sortable: true
            ,width: 40
            ,editor: { xtype: 'textfield' }
        },{
            header: _('imports.away')
            ,dataIndex: 'away'
            ,sortable: true
            ,width: 40
            ,editor: { xtype: 'textfield' }
        },{
            header: _('imports.createdon')
            ,dataIndex: 'createdon'
            ,sortable: true
            ,width: 120
            ,editor: { xtype: 'textfield' }
        }]
        ,tbar:[{
            text: _('imports.import_create')
            ,handler: { xtype: 'imports-window-import-create' ,blankValues: true }
            
        },{
            xtype: 'tbseparator'
            ,cls: 'xtb-break'
            ,width: 20
        },{
            xtype: 'modx-combo'
            ,name: 'type'
            ,width: 125
            ,id: 'imports-filter-type'
            ,store: [
                ['-', 'Alle Arten'],
                ['video', 'Video'],
                ['audio', 'OnEar Stream'],
                ['prereport', 'Vorbericht'],
                ['postreport', 'Nachbericht']
            ]
            ,editable: false
            ,triggerAction: 'all'
            ,lastQuery: ''
            ,hiddenName: 'type'
            ,submitValue: false
            ,emptyText: 'Alle Arten'
            ,listeners: {
                'change': {fn: this.filterType, scope: this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            xtype: 'tbseparator'
            ,cls: 'xtb-break'
            ,width: 5
        },{
            xtype: 'modx-combo'
            ,name: 'season'
            ,width: 120
            ,id: 'imports-filter-season'
            ,store: [
                ['-', 'Alle Saisonen'],
                ['20092010', '2009/2010'],
                ['20102011', '2010/2011'],
                ['20112012', '2011/2012'],
                ['20122013', '2012/2013'],
                ['20132014', '2013/2014'],
                ['20142015', '2014/2015'],
                ['20152016', '2015/2016']
            ]
            ,editable: false
            ,triggerAction: 'all'
            ,lastQuery: ''
            ,hiddenName: 'season'
            ,submitValue: false
            ,emptyText: 'Alle Saisonen'
            ,listeners: {
                'change': {fn: this.filterSeason, scope: this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            xtype: 'tbseparator'
            ,cls: 'xtb-break'
            ,width: 5
        },{
            xtype: 'modx-combo'
            ,name: 'league'
            ,width: 100
            ,id: 'imports-filter-league'
            ,store: [
                ['-', 'Alle Ligen'],
                ['BL1', 'BL1'],
                ['BL2', 'BL2']
            ]
            ,editable: false
            ,triggerAction: 'all'
            ,lastQuery: ''
            ,hiddenName: 'league'
            ,submitValue: false
            ,emptyText: 'Alle Ligen'
            ,listeners: {
                'change': {fn: this.filterLeague, scope: this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            xtype: 'tbseparator'
            ,cls: 'xtb-break'
            ,width: 5
        },{
            xtype: 'modx-combo'
            ,name: 'round'
            ,width: 110
            ,id: 'imports-filter-round'
            ,store: [
                ['-', 'Alle Runden'],
                [1, '1. Runde'],
                [2, '2. Runde'],
                [3, '3. Runde'],
                [4, '4. Runde'],
                [5, '5. Runde'],
                [6, '6. Runde'],
                [7, '7. Runde'],
                [8, '8. Runde'],
                [9, '9. Runde'],
                [10, '10. Runde'],
                [11, '11. Runde'],
                [12, '12. Runde'],
                [13, '13. Runde'],
                [14, '14. Runde'],
                [15, '15. Runde'],
                [16, '16. Runde'],
                [17, '17. Runde'],
                [18, '18. Runde'],
                [19, '19. Runde'],
                [20, '20. Runde'],
                [21, '21. Runde'],
                [22, '22. Runde'],
                [23, '23. Runde'],
                [24, '24. Runde'],
                [25, '25. Runde'],
                [26, '26. Runde'],
                [27, '27. Runde'],
                [28, '28. Runde'],
                [29, '29. Runde'],
                [30, '30. Runde'],
                [31, '31. Runde'],
                [32, '32. Runde'],
                [33, '33. Runde'],
                [34, '34. Runde'],
                [35, '35. Runde'],
                [36, '36. Runde']
            ]
            ,editable: false
            ,triggerAction: 'all'
            ,lastQuery: ''
            ,hiddenName: 'round'
            ,submitValue: false
            ,emptyText: 'Alle Runden'
            ,listeners: {
                'change': {fn: this.filterRound, scope: this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            xtype: 'tbseparator'
            ,cls: 'xtb-break'
            ,width: 5
        },{
            xtype: 'modx-combo'
            ,name: 'game'
            ,width: 110
            ,id: 'imports-filter-game'
            ,store: [
                ['-', 'Alle Spiele'],
                [1, 'Spiel 1'],
                [2, 'Spiel 2'],
                [3, 'Spiel 3'],
                [4, 'Spiel 4'],
                [5, 'Spiel 5']
            ]
            ,editable: false
            ,triggerAction: 'all'
            ,lastQuery: ''
            ,hiddenName: 'game'
            ,submitValue: false
            ,emptyText: 'Alle Spiele'
            ,listeners: {
                'change': {fn: this.filterGame, scope: this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true;}
                        ,scope: cmp
                    });
                },scope:this}
            }
        },{
            xtype: 'tbseparator'
            ,cls: 'xtb-break'
            ,width: 20
        },{
            xtype: 'textfield'
            ,width: 120
            ,id: 'imports-search-filter'
            ,emptyText: _('imports.search...')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        
        }]
        ,getMenu: function() {
            return [{
                text: _('imports.import_update')
                ,handler: this.updateImport
            },'-',{
                text: _('imports.import_remove')
                ,handler: this.removeImport
            }];
        }
        ,updateImport: function(btn,e) {
            if (!this.updateImportWindow) {
                this.updateImportWindow = MODx.load({
                    xtype: 'imports-window-import-update'
                    ,record: this.menu.record
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateImportWindow.setValues(this.menu.record);
            this.updateImportWindow.show(e.target);
        }
        
        ,removeImport: function() {
            MODx.msg.confirm({
                title: _('imports.import_remove')
                ,text: _('imports.import_remove_confirm')
                ,url: this.config.url
                ,params: {
                    action: 'mgr/import/remove'
                    ,id: this.menu.record.id
                }
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
    });
    Imports.grid.Imports.superclass.constructor.call(this,config)
};
Ext.extend(Imports.grid.Imports,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,filterType: function(tf,newValue,oldValue) {
        var nv = newValue;
        var s = this.getStore();
        if(nv == '-') {
            delete s.baseParams.type;
        } else {
            s.baseParams.type = nv;
        }
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,filterSeason: function(tf,newValue,oldValue) {
        var nv = newValue;
        var s = this.getStore();
        if(nv == '-') {
            delete s.baseParams.season;
        } else {
            s.baseParams.season = nv;
        }
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,filterLeague: function(tf,newValue,oldValue) {
        var nv = newValue;
        var s = this.getStore();
        if(nv == '-') {
            delete s.baseParams.league;
        } else {
            s.baseParams.league = nv;
        }
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,filterRound: function(tf,newValue,oldValue) {
        var nv = newValue;
        var s = this.getStore();
        if(nv == '-') {
            delete s.baseParams.round;
        } else {
            s.baseParams.round = nv;
        }
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
    ,filterGame: function(tf,newValue,oldValue) {
        var nv = newValue;
        var s = this.getStore();
        if(nv == '-') {
            delete s.baseParams.game;
        } else {
            s.baseParams.game = nv;
        }
        this.getBottomToolbar().changePage(1);
        this.refresh();
        return true;
    }
        
});
Ext.reg('imports-grid-imports',Imports.grid.Imports);

Imports.window.UpdateImport = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('imports.import_update')
        ,url: Imports.config.connectorUrl
        ,baseParams: {
            action: 'mgr/import/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('imports.type')
            ,store: [
                [1,'video'],
                [2,'audio'],
                [3,'vorbericht'],
                [4,'nachbericht']
            ]
            ,name: 'type'
            ,anchor: '40%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.resource')
            ,name: 'resource'
            ,anchor: '30%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.season')
            ,name: 'season'
            ,anchor: '30%'
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('imports.league')
            ,name: 'league'
            ,store: [
                [1,'bl1'],
                [2,'bl2']
            ]
            ,anchor: '30%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.round')
            ,name: 'round'
            ,anchor: '30%'
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('imports.game')
            ,name: 'game'
            ,store: [
                [1,'1'],
                [2,'2'],
                [3,'3'],
                [4,'4'],
                [5,'5']
            ]
            ,anchor: '30%'
        
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.home')
            ,name: 'home'
            ,anchor: '30%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.away')
            ,name: 'away'
            ,anchor: '30%'
        }]
    });
    Imports.window.UpdateImport.superclass.constructor.call(this,config);
};
Ext.extend(Imports.window.UpdateImport,MODx.Window);
Ext.reg('imports-window-import-update',Imports.window.UpdateImport);

Imports.window.CreateImport = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('imports.import_create')
        ,url: Imports.config.connectorUrl
        ,baseParams: {
            action: 'mgr/import/create'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('imports.type')
            ,store: [
                [1,'video'],
                [2,'audio'],
                [3,'vorbericht'],
                [4,'nachbericht']
            ]
            ,name: 'type'
            ,anchor: '40%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.resource')
            ,name: 'resource'
            ,anchor: '30%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.season')
            ,name: 'season'
            ,anchor: '30%'
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('imports.league')
            ,name: 'league'
            ,store: [
                [1,'bl1'],
                [2,'bl2']
            ]
            ,anchor: '30%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.round')
            ,name: 'round'
            ,anchor: '30%'
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('imports.game')
            ,name: 'game'
            ,store: [
                [1,'1'],
                [2,'2'],
                [3,'3'],
                [4,'4'],
                [5,'5']
            ]
            ,anchor: '30%'
        
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.home')
            ,name: 'home'
            ,anchor: '30%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('imports.away')
            ,name: 'away'
            ,anchor: '30%'
        }]
    });
    Imports.window.CreateImport.superclass.constructor.call(this,config);
};
Ext.extend(Imports.window.CreateImport,MODx.Window);
Ext.reg('imports-window-import-create',Imports.window.CreateImport);