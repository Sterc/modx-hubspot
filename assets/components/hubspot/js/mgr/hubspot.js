var Hubspot = function(config) {
    config = config || {};

    Hubspot.superclass.constructor.call(this, config);
};

Ext.extend(Hubspot, Ext.Component, {
    page    : {},
    window  : {},
    grid    : {},
    tree    : {},
    panel   : {},
    combo   : {},
    config  : {}
});

Ext.reg('hubspot', Hubspot);

Hubspot = new Hubspot();