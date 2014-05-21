Ext.ux.form.AddressField = Ext.extend(Ext.form.TwinTriggerField, {
	trigger1Class: 'x-form-clear-trigger',
	trigger2Class: 'm-form-link-trigger',
	enableKeyEvents: true,
	resultData: null,

	initComponent: function(){
		this.addListener({
			keyup: {
				fn: function(field, event) {
					this.task.cancel();
					this.task.delay(500);
				},
				scope: this
			}
		});

		this.task = new Ext.util.DelayedTask(this.searchAddress, this);

		this.addressSearch = new Phlexible.googlemaps.AddressSearch({
			resultData: this.resultData,
			listeners: {
				results: {
					fn: function(addressSearch, results, status) {
						this.displayResults(results);
					},
					scope: this
				},
				error: {
					fn: function() {
						this.displayResults('NO_GEOCODER', true);
					},
					scope: this
				},
				select: {
					fn: function(addressSearch, resultData) {
						this.resultData = resultData;
						this.setValue(resultData.formatted);
						this.clearPendingResults();
						this.clearError();
						//this.clearInvalid();
						if (this.triggers) {
							this.triggers[0].show();
						} else {
							this.hideTrigger1 = false;
						}

					},
					scope: this
				},
				reset: {
					fn: function() {
						this.clearPendingResults();
					},
					scope: this
				}
			}
		});

		if (!Phlexible.googlemaps.mapwin) {
			Phlexible.googlemaps.mapwin = new Phlexible.googlemaps.MapWindow();
		}

		Ext.ux.form.AddressField.superclass.initComponent.call(this);
	},

	initTrigger: function() {
		var ts = this.trigger.select('.x-form-trigger', true);
//        this.wrap.setStyle('overflow', 'hidden');
		var triggerField = this;
		ts.each(function(t, all, index){
			t.hide = function(){
				var w = triggerField.wrap.getWidth() || triggerField.width || 100;
				this.dom.style.display = 'none';
				triggerField.el.setWidth(w-triggerField.trigger.getWidth());
			};
			t.show = function(){
				var w = triggerField.wrap.getWidth() || triggerField.width || 100;
				this.dom.style.display = '';
				triggerField.el.setWidth(w-triggerField.trigger.getWidth());
			};
			var triggerIndex = 'Trigger'+(index+1);

			if(this['hide'+triggerIndex]){
				t.dom.style.display = 'none';
			}
			t.on("click", this['on'+triggerIndex+'Click'], this, {preventDefault:true});
			t.addClassOnOver('x-form-trigger-over');
			t.addClassOnClick('x-form-trigger-click');
		}, this);
		this.triggers = ts.elements;
	},

	searchAddress: function() {
		var address = this.getValue();

		if (this.addressSearch) {
			this.addressSearch.search(address);
		} else {
			this.displayResults();
		}
	},

	displayResults: function(v, error) {
		if (v && error) {
			this.errorEl.update(v);
			this.errorEl.parent().show();
			this.clearPendingResults();
			this.triggers[0].show();
		}
		else if (v && !error) {
			this.clearPendingResults();
			var usedResults = 0;
			for (var i=0; i<v.length; i++) {
				// show only 5 results
				if (usedResults >= 5) break;

				// only use results of type 'route' and 'street_address'
				if (v[i].types.indexOf('route') === -1 && v[i].types.indexOf('street_address') === -1) continue;

				// render result link
				this.resultEl.createChild({
					tag: 'div'
				}).createChild({
					tag: 'a',
					id: 'googlemaps_field_result_' + i,
					href: 'javascript:void(0);',
					html: v[i]['formatted_address'] + ' [' + v[i].types[0] + ']'
				});
				this.resultEl.show();
				usedResults++;
			}

			// only use on at least one valid result
			if (usedResults) {
				this.results = v;
				this.clearError();
				this.triggers[0].show();
			}
			else {
				v = null;
			}
		}

		if (!v) {
			this.clearPendingResults();
			this.clearError();
			this.triggers[0].hide();
		}

		this.validate();
	},

	useAddress: function(e, el) {
		var match = el.id.match(/^googlemaps_field_result_([0-9]+)$/);
		if (!match[1]) {
			return;
		}

		var resultData = this.addressSearch.selectResult(match[1]);
	},

	clearValue: function() {
		this.addressSearch.clear();
		this.resultData = null;
		this.setValue('');
		this.triggers[0].hide();
		this.clearPendingResults();
		this.clearError();
	},

	clearPendingResults: function() {
		if (this.resultEl) {
			this.resultEl.update('');
			this.resultEl.hide();
		}
	},

	clearError: function() {
		if (this.errorEl) {
			this.errorEl.update('');
			this.errorEl.parent().hide();
		}
	},

	onClear: Ext.emptyFn,

	validateValue: function(value) {
		if (this.addressSearch.isPending()) {
			this.markInvalid();
			return false;
		}

		return Ext.ux.form.AddressField.superclass.validateValue.call(this, value);
	},

	onTrigger1Click: function(){
		this.clearValue();
		this.onClear();
		this.fireEvent('clear', this);
	},

	onTrigger2Click: function(){
		this.showMap(this.addressSearch);
	},

	showMap: function(resultData) {
		Phlexible.googlemaps.mapwin.show(resultData);
	},

	syncValue: function() {
		if (this.addressSearch.hasResultData()) {
			this.hiddenField.dom.value = Ext.encode(this.addressSearch.getResultData());
		}
		else {
			this.hiddenField.dom.value = '';
		}
	},

	// private
	onRender : function(ct, position){
		Ext.ux.form.AddressField.superclass.onRender.call(this, ct, position);

		this.resultEl = this.el.parent().createChild({
			tag: "div",
			cls: 'm-form-address-result',
			hidden: true
		});
		this.errorEl = this.el.parent().createChild({
			tag: "div",
			cls: 'm-form-address-result',
			hidden: true
		}).createChild({
			tag: 'span',
			style: 'color: red;'
		});

		this.resultEl.on('mousedown', this.useAddress, this, {delegate:'a'});
		this.resultEl.on('click', Ext.emptyFn, null, {delegate:'a', preventDefault:true});

		this.hiddenField = this.wrap.createChild({
			tag: 'input',
			type: 'hidden',
			name: this.hiddenName,
			value: ''
		});
	}
});
Ext.reg('addressfield', Ext.ux.form.AddressField);
