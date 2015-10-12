Ext.require('Phlexible.fields.Registry');
Ext.require('Phlexible.fields.FieldTypes');
Ext.require('Phlexible.fields.FieldHelper');
Ext.require('Phlexible.googlemaps.field.AddressField');

Phlexible.fields.Registry.addFactory('address', function(parentConfig, item, valueStructure, element, repeatableId) {
	var config = Phlexible.fields.FieldHelper.defaults(parentConfig, item, valueStructure, element, repeatableId);

	Ext.apply(config, {
		xtype: 'addressfield',
		hiddenName: config.name,

		width: (parseInt(item.configuration.width, 10) || 200),

		hideTrigger1: (item.rawContent ? false : true),
		hideTrigger2: false,

		supportsPrefix: true,
		supportsSuffix: true,
		supportsDiff: true,
		supportsInlineDiff: true,
		supportsUnlink: {unlinkEl: 'trigger'},
		supportsRepeatable: true
	});

    if (config.value) {
        config.resultData = config.value;
        config.value = config.value.formatted || config.value.query;
    }

	if (config.readOnly) {
		config.editable = false;
		config.hideTrigger1 = true;
		config.hideTrigger2 = true;
		config.onTrigger1Click = Ext.emptyFn;
		config.onTrigger2Click = Ext.emptyFn;
	}

	delete config.name;

	return config;
});

Phlexible.fields.FieldTypes.addField('address', {
    titles: {
        de: 'Adresse',
        en: 'Address'
    },
    iconCls: 'p-googlemaps-component-icon',
    allowedIn: [
		'tab',
		'accordion',
		'group',
		'referenceroot'
	],
    config: {
        labels: {
            field: 1,
            box: 0,
            prefix: 1,
            suffix: 1,
            help: 1
        },
        configuration: {
            required: 1,
            sync: 1,
            width: 1,
            height: 0,
            readonly: 1,
            hide_label: 1,
            sortable: 0
        }
    }
});
