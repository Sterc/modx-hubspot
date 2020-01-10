Hubspot.panel.Home = function(config) {
    config = config || {};

    Ext.apply(config, {
        url         : Hubspot.config.connector_url,
        baseParams  : {
            action      : 'mgr/settings/save',
            id          : MODx.request.id
        },
        id          : 'hubspot-panel-home',
        cls         : 'container',
        items       : [{
            html        : '<h2>' + _('hubspot') + '</h2>',
            cls         : 'modx-page-header'
        }, {
            layout      : 'form',
            items       : [{
                html        : '<p>' + _('hubspot.setup_desc') + '</p>',
                bodyCssClass : 'panel-desc'
            }, {
                xtype       : 'panel',
                layout      : 'form',
                cls         : 'main-wrapper',
                labelAlign  : 'top',
                labelSeparator : '',
                items       : [{
                    xtype       : 'hidden',
                    name        : 'context_key',
                    anchor      : '100%',
                    value       : MODx.request.context || MODx.config.default_context
                }, {
                    xtype       : 'textarea',
                    fieldLabel  : _('hubspot.label_setup_tracking_code'),
                    description : MODx.expandHelp ? '' : _('hubspot.label_setup_tracking_code_desc'),
                    name        : 'tracking_code',
                    anchor      : '100%',
                    allowBlank  : true
                }, {
                    xtype       : MODx.expandHelp ? 'label' : 'hidden',
                    html        : _('hubspot.label_setup_tracking_code_desc'),
                    cls         : 'desc-under'
                }]
            }]
        }],
        listeners   : {
            'setup'     : {
                fn          : this.onSetup,
                scope       : this
            }
        }
    });

    Hubspot.panel.Home.superclass.constructor.call(this, config);
};

Ext.extend(Hubspot.panel.Home, MODx.FormPanel, {
    initialized: false,

    onSetup: function() {
        if (!this.initialized) {
            this.getForm().setValues(this.record);

            this.initialized = true;
        }

        this.fireEvent('ready');
    }
});

Ext.reg('hubspot-panel-home', Hubspot.panel.Home);