Makeweb.googlemaps.AddressSearch = function(config) {
    config = config || {};

    /**
     * This Component's initial configuration specification. Read-only.
     * @type Object
     * @property initialConfig
     */
    this.initialConfig = config;

    if (!config.geocoder && google && google.maps && google.maps.Geocoder) {
        config.geocoder = new google.maps.Geocoder();
    }

    Ext.apply(this, config);

    this.addEvents(
        /**
         * @event results
         * Fires after a valid search result has been received.
         * @param {Makeweb.googlemaps.Search} this
         * @param {Object} results
         * @param {String} status
         */
        'results',
        /**
         * @event error
         * Fires after a search produced an error.
         * @param {Makeweb.googlemaps.Search} this
         * @param {Object} results
         * @param {String} status
         */
        'error',
        /**
         * @event result
         * Fires after a search result has been selected.
         * @param {Makeweb.googlemaps.Search} this
         * @param {Object} result
         */
        'result',
        /**
         * @event reset
         * Fires after a pending search has been reset.
         * @param {Makeweb.googlemaps.Search} this
         */
        'reset',
        /**
         * @event clear
         * Fires after everything has been cleared.
         * @param {Makeweb.googlemaps.Search} this
         */
        'clear'
    );

    /**
     * @cfg {Object} listeners (optional) A config object containing one or more event handlers to be added to this
     * object during initialization.  This should be a valid listeners config object as specified in the
     * {@link #addListener} example for attaching multiple handlers at once.
     */
    if(this.listeners) {
        this.on(this.listeners);
        delete this.listeners;
    }
};
Ext.extend(Makeweb.googlemaps.AddressSearch, Ext.util.Observable, {
    pendingQuery: null,
    pendingResults: null,
    resultData: null,

    search: function(query) {
        this.pendingQuery = query;
        this.geocoder.geocode({'address': query}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                this.pendingResults = results;
                this.fireEvent('results', this, results, status);
            } else {
                this.fireEvent('error', this, results, status);
            }
        }.createDelegate(this));
    },

    isPending: function() {
        return !!this.pendingQuery;
    },

    hasResultData: function() {
        return !!this.resultData;
    },

    selectResult: function(index) {
        var result = this.pendingResults[index];

        var data = {
            //type: result.types[0],
            formatted: result.formatted_address,
            query: this.pendingQuery,
            address: {
                street: '',
                number: '',
                district: '',
                postal: '',
                city: '',
                region: '',
                state: '',
                country: '',
                countryCode: ''
            },
            geometry: {
                lat: result.geometry.location.lat(),
                lng: result.geometry.location.lng()
            }
        };

        for (var i=0; i<result.address_components.length; i++) {
            var item = result.address_components[i];

            if (item.types.indexOf('route') !== -1) {
                data.address.street = item.long_name;
            }
            else if (item.types.indexOf('street_number') !== -1) {
                data.address.number = item.long_name;
            }
            else if (item.types.indexOf('postal_code') !== -1) {
                data.address.postal = item.long_name;
            }
            else if (item.types.indexOf('sublocality') !== -1) {
                data.address.district = item.long_name;
            }
            else if (item.types.indexOf('locality') !== -1) {
                data.address.city = item.long_name;
            }
            else if (item.types.indexOf('administrative_area_level_2') !== -1) {
                data.address.region = item.long_name;
            }
            else if (item.types.indexOf('administrative_area_level_1') !== -1) {
                data.address.state = item.long_name;
            }
            else if (item.types.indexOf('country') !== -1) {
                data.address.country = item.long_name;
                data.address.countryCode = item.short_name;
            }
        }

        this.setResultData(data);

        return this.resultData;
    },

    getFormatted: function(resultData) {
        var parts = [];
        
        if (resultData.address.street) {
            var v = resultData.address.street;
            
            if (resultData.address.number) {
                v += ' ' + resultData.address.number;
            }
            
            parts.push(v);
        }
        
        if (resultData.address.postal || resultData.address.city) {
            var v = [];
            
            if (resultData.address.postal) {
                v.push(resultData.address.postal);
            }
            if (resultData.address.city) {
                v.push(resultData.address.city);
            }
            
            parts.push(v.join(' '));
        }
        
        if (resultData.address.country) {
            parts.push(resultData.address.country);
        }
        
        var formatted = parts.join(', ');
        
        return formatted;
    },
    
    setResultData: function(resultData) {
        this.reset();

        resultData.formatted = this.getFormatted(resultData);
        
        this.resultData = resultData;
        this.fireEvent('select', this, this.resultData);
    },

    getResultData: function() {
        return this.resultData;
    },

    clear: function() {
        this.reset();

        this.resultData = null;

        this.fireEvent('clear', this);
    },

    reset: function() {
        this.pendingQuery = null;
        this.pendingResults = null;

        this.fireEvent('reset', this);
    }
});
