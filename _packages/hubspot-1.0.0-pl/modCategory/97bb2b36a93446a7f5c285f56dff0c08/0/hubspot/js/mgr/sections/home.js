Ext.onReady(function() {
    MODx.load({
        xtype : 'hubspot-page-home'
    });
});

Hubspot.page.Home = function(config) {
    config = config || {};

    config.buttons = [];

    if (Hubspot.config.branding_url) {
        config.buttons.push({
            text        : 'HubSpot ' + Hubspot.config.version,
            cls         : 'x-btn-branding',
            handler     : this.loadBranding
        });
    }

    config.buttons.push({
        xtype       : 'modx-combo-context',
        hidden      : !Hubspot.config.context_aware,
        value       : MODx.request.context || MODx.config.default_context,
        name        : 'hubspot-filter-context',
        emptyText   : _('hubspot.filter_context'),
        displayField : 'name',
        listeners   : {
            'select'    : {
                fn          : this.filterContext,
                scope       : this
            }
        },
        baseParams  : {
            action      : 'context/getlist',
            exclude     : 'mgr'
        }
    }, {
        text        : _('save'),
        cls         : 'primary-button',
        id          : 'modx-abtn-save',
        method      : 'remote',
        process     : 'mgr/settings/save',
        keys        : [{
            ctrl        : true,
            key         : MODx.config.keymap_save || 's'
        }]
    });

    if (Hubspot.config.branding_url_help) {
        config.buttons.push({
            text        : _('help_ex'),
            handler     : MODx.loadHelpPane,
            scope       : this
        });
    }

    Ext.applyIf(config, {
        formpanel   : 'hubspot-panel-home',
        components  : [{
            xtype       : 'hubspot-panel-home',
            record      : Hubspot.config.record
        }]
    });

    Hubspot.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(Hubspot.page.Home, MODx.Component, {
    loadBranding: function(btn) {
        window.open(Hubspot.config.branding_url);
    },
    filterContext: function(tf) {
        MODx.loadPage('?a=home&namespace=' + Hubspot.config.namespace + '&context=' + tf.getValue());
    }
});

Ext.reg('hubspot-page-home', Hubspot.page.Home);