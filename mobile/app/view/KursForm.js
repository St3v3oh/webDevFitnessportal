Ext.define('Kursliste.view.KursForm', {
	extend: 'Ext.form.Panel',
	xtype: 'kursform',
	requires: [
		'Ext.field.DatePicker'
	],
	config: {
		items: [
			{
				xtype: 'textfield',
				name: 'title',
				label: 'Titel',
				readOnly: true
			},
			{
				xtype: 'textfield',
				name: 'trainer',
				label: 'Trainer',
				readOnly: true
			},
			{
				xtype: 'textfield',
				name: 'startdate',
				label: 'Datum',
				readOnly: true
			},
			{
				xtype: 'textareafield',
				name: 'notes',
				label: 'Notizen',
				readOnly: true
			}
		]
	}
});