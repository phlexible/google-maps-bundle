Phlexible.fields.Registry.addFactory('address', function(parentConfig, item, valueStructure, element, repeatableId) {
	element.prototypes.incCount(item.dsId);

	var config = Phlexible.fields.FieldHelper.defaults(parentConfig, item, valueStructure, element, repeatableId);

	Ext.apply(config, {
		xtype: 'addressfield',
		hiddenName: config.name,

		value: item.rawContent ? item.rawContent.formatted : null,
		width: (parseInt(item.configuration.width, 10) || 200),

		resultData: item.rawContent || null,
		hideTrigger1: (item.rawContent ? false : true),
		hideTrigger2: false,

		supportsPrefix: true,
		supportsSuffix: true,
		supportsDiff: true,
		supportsInlineDiff: true,
		supportsUnlink: {unlinkEl: 'trigger'},
		supportsRepeatable: true
	});

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
            sync: 1,
            width: 1,
            height: 0,
            readonly: 0,
            hide_label: 1,
            sortable: 0
        },
        /*
        values: {
            default_text: 0,
            default_number: 0,
            default_textarea: 0,
            default_date: 0,
            default_time: 0,
            default_select: 0,
            default_link: 1,
            default_checkbox: 0,
            default_table: 0,
            source: 0,
            source_values: 0,
            source_function: 0,
            source_datasource: 0,
            text: 0
        },
        */
        validation: {
            required: 1,
            text: 0,
            numeric: 0,
            content: 0
        }
    }
});
