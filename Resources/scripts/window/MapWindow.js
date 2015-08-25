Ext.provide('Phlexible.googlemaps.window.MapWindow');

Ext.require('Phlexible.googlemaps.util.AddressSearch');

Phlexible.googlemaps.window.MapWindow = Ext.extend(Ext.Window, {
    title: Phlexible.googlemaps.Strings.address,
    strings: Phlexible.googlemaps.Strings,
    width: 800,
    minWidth: 800,
    height: 520,
    minHeight: 520,
    maximizable: false,
    resizable: false,
    modal: true,
    closeAction: 'hide',
    constrainHeader: true,
    layout: 'border',

    initComponent: function() {
        this.items = [{
            xtype: 'panel',
            region: 'center',
            html: '',
            listeners: {
                render: {
                    fn: this.renderMap,
                    scope: this
                }
            }
        },{
            xtype: 'form',
            region: 'east',
            width: 300,
            bodyStyle: 'padding: 5px;',
            items: [{
                xtype: 'fieldset',
                title: this.strings.address,
                autoHeight: true,
                items: [{
                    xtype: 'textfield',
                    name: 'street',
                    fieldLabel: this.strings.street,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'number',
                    fieldLabel: this.strings.number,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'district',
                    fieldLabel: this.strings.district,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'postal',
                    fieldLabel: this.strings.postal,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'city',
                    fieldLabel: this.strings.city,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'region',
                    fieldLabel: this.strings.region,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'state',
                    fieldLabel: this.strings.state,
                    anchor: '-10'
                },{
                    xtype: 'textfield',
                    name: 'country',
                    fieldLabel: this.strings.country,
                    anchor: '-10'
                }],
                buttons: [{
                    text: this.strings.query_by_address,
                    handler: function() {
                        var values = this.getComponent(1).getForm().getValues();
                        var q = values.street + ' ' + values.number + ', ' + values.postal + ' ' + values.city + ', ' + values.country;

                        var combo = this.getTopToolbar().items.items[0];
                        //combo.setValue(q);
                        combo.doQuery(q, true);
                        combo.onTriggerClick();
                    },
                    scope: this
                }]
            },{
                xtype: 'fieldset',
                title: this.strings.coordinates,
                autoHeight: true,
                items: [{
                    xtype: 'numberfield',
                    name: 'lat',
                    fieldLabel: this.strings.latitude,
                    allowDecimals: true,
                    decimalPrecision: 18,
                    anchor: '-10'
                },{
                    xtype: 'numberfield',
                    name: 'lng',
                    fieldLabel: this.strings.longitude,
                    allowDecimals: true,
                    decimalPrecision: 18,
                    anchor: '-10'
                }],
                buttons: [{
                    text: this.strings.query_by_coordinates,
                    handler: function() {
                        var values = this.getComponent(1).getForm().getValues();
                        var q = values.lat + ',' + values.lng;

                        var combo = this.getTopToolbar().items.items[0];
                        combo.setValue(q);
                        combo.doQuery(q, true);
                        combo.onTriggerClick();
                    },
                    scope: this
                }]
            }],
            buttons: [{
                text: this.strings.update,
                handler: function() {
                    var resultData = this.addressSearch.getResultData();

                    var values = this.getComponent(1).getForm().getValues();
                    resultData.address.street = values.street;
                    resultData.address.number = values.number;
                    resultData.address.district = values.district;
                    resultData.address.postal = values.postal;
                    resultData.address.city = values.city;
                    resultData.address.region = values.region;
                    resultData.address.state = values.state;
                    resultData.address.country = values.country;
                    resultData.geometry.lat = values.lat;
                    resultData.geometry.lng = values.lng;

                    this.callerAddressSearch.setResultData(resultData);
                    this.hide();
                },
                scope: this
            },{
                text: this.strings.cancel,
                handler: function() {
                    this.hide();
                },
                scope: this
            }],
            listeners: {
                render: {
                    fn: this.renderForm,
                    scope: this
                }
            }
        }];

        this.tbar = [{
            xtype: 'twincombobox',
            width: 760,
            hiddenName: 'query',
            store: new Ext.data.SimpleStore({
                fields: ['id', 'value']
            }),
            emptyText: this.strings.query,
            displayField: 'value',
            valueField: 'id',
            mode: 'local',
            typeAhead: false,
            triggerAction: 'all',
            selectOnFocus: true,
            editable: true,
            listeners: {
                render: {
                    fn: this.renderQuery,
                    scope: this
                },
                beforequery: {
                    fn: function(qe) {
                        this.addressSearch.search(qe.query);

                        return false;
                    },
                    scope: this
                },
                select: {
                    fn: function(combo, record, index) {
                        this.addressSearch.selectResult(index);
                    },
                    scope: this
                }
            }

        }];

        this.addressSearch = new Phlexible.googlemaps.util.AddressSearch({
            listeners: {
                results: {
                    fn: function(addressSearch, results, status) {
                        var combo = this.getTopToolbar().items.items[0];
                        var store = combo.store;

                        var data = [];
                        for (var i=0; i<results.length; i++) {
                            data.push([i, results[i].formatted_address]);
                        }

                        store.loadData(data);
                        combo.onLoad();
                    },
                    scope: this
                },
                error: {
                    fn: function() {
                    },
                    scope: this
                },
                select: {
                    fn: function(addressSearch, resultData) {
                        this.activateResultData(resultData);
                    },
                    scope: this
                },
                reset: {
                    fn: function() {
                    },
                    scope: this
                }
            }
        });

        Phlexible.googlemaps.window.MapWindow.superclass.initComponent.call(this);
    },

    updateFromForm: function() {
        var values = this.getComponent(1).getForm().getValues();

        this.addressSearch.resultData.address.street = values.street;
        this.addressSearch.resultData.address.number = values.number;
        this.addressSearch.resultData.address.district = values.district;
        this.addressSearch.resultData.address.postal = values.postal;
        this.addressSearch.resultData.address.city = values.city;
        this.addressSearch.resultData.address.region = values.region;
        this.addressSearch.resultData.address.state = values.state;
        this.addressSearch.resultData.address.country = values.country;
        this.addressSearch.resultData.geometry.lat = values.lat;
        this.addressSearch.resultData.geometry.lng = values.lng;
    },

    xonRender: function(a,b) {
        Phlexible.googlemaps.window.MapWindow.superclass.onRender.call(this, a, b);
    },

    renderMap: function(c) {
        var mapOptions = {
          zoom: 16,
          center: this.latlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        this.map = new google.maps.Map(c.body.dom, mapOptions);

        var markerOptions = {
            position: this.latlng,
            map: this.map,
            title: this.markerTitle,
            draggable: true
        };

        this.marker = new google.maps.Marker(markerOptions);

        google.maps.event.addListener(this.marker, 'dragend', function(e) {
            var lat = e.latLng.lat();
            var lng = e.latLng.lng();

            this.getComponent(1).getComponent(1).getComponent(0).setValue(lat);
            this.getComponent(1).getComponent(1).getComponent(1).setValue(lng);
            this.updateFromForm();
        }.createDelegate(this));

        /*
        var infoWindowOptions = {
            position: this.latlng,
            content: this.markerTitle
        };

        this.infoWindow = new google.maps.InfoWindow(infoWindowOptions);
        this.infoWindow.open(this.map);
        */
    },

    renderForm: function(c) {
        if (this.addressSearch.hasResultData()) {
            var resultData = this.addressSearch.getResultData();
            var values = Ext.apply(resultData.address, resultData.geometry);
            c.getForm().setValues(values);
        }
        else {
            c.getForm().reset();
        }
    },

    renderQuery: function(c) {
        if (this.addressSearch.hasResultData()) {
            var resultData = this.addressSearch.getResultData();
            c.setRawValue(resultData.formatted);
        }
        else {
            c.setRawValue('');
        }
    },

    show: function(addressSearch) {
        this.callerAddressSearch = addressSearch;
        this.addressSearch.reset();
        this.addressSearch.resultData = addressSearch.resultData;

        if (this.addressSearch.hasResultData()) {
            var resultData = this.addressSearch.getResultData();

            this.activateResultData(resultData);
        }
        else {
            this.emptyResult();
        }

        Phlexible.googlemaps.window.MapWindow.superclass.show.call(this);
    },

    activateResultData: function(resultData) {
        this.setTitle(resultData.formatted);
        this.markerTitle = resultData.formatted;

        this.latlng = new google.maps.LatLng(resultData.geometry.lat, resultData.geometry.lng);

        if (this.map) {
            this.map.setCenter(this.latlng);
            this.marker.setPosition(this.latlng);
            this.marker.setTitle(resultData.formatted);
            //this.infoWindow.setPosition(this.latlng);
            //this.infoWindow.setContent(title);
        }

        if (this.getTopToolbar().items) this.renderQuery(this.getTopToolbar().items.items[0]);
        if (this.getComponent(1).rendered) this.renderForm(this.getComponent(1));
    },

    emptyResult: function() {
        this.setTitle('');
        this.markerTitle = '';

        if (this.getTopToolbar().items) this.renderQuery(this.getTopToolbar().items.items[0]);
        if (this.getComponent(1).rendered) this.renderForm(this.getComponent(1));
    }
});

