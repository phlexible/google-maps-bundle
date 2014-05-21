Phlexible.fields.Registry.addFactory('address', function(parentConfig, item, valueStructure, pos, element, repeatablePostfix, forceAdd) {
	if (element.master) {
		element.prototypes.addFieldPrototype(item);
	}

	element.prototypes.incCount(item.ds_id);

	var config = Phlexible.fields.FieldHelper.defaults(parentConfig, item, element, repeatablePostfix, forceAdd);

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
    allowedIn: ['tab','accordion','group','referenceroot'],
    iconCls: 'm-googlemaps-component-icon',
    accordions: ['fieldproperties','fieldlabels','fieldconfiguration','fieldvalues','fieldvalidation'],
    config: {
        properties: {
        },
        labels: {
            field: 1,
            box: 0,
            prefix: 1,
            suffix: 1,
            context: 1
        },
        configuration: {
            sync: 1,
            width: 1,
            height: 0,
            readonly: 0,
            hide_label: 1,
            sortable: 0,
            repeat: 0,
            group: 0,
            link: 0,
            table: 0,
            accordion: 0
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
