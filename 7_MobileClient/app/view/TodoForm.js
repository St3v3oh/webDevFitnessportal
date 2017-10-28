Ext.define('Todoliste.view.TodoForm', {
	extend: 'Ext.form.Panel',
	xtype: 'todoform',
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
				name: 'author',
				label: 'Autor',
				readOnly: true
			},
			{
				xtype: 'datepickerfield',
				name: 'due_date',
				label: 'Fällig',
				readOnly: true,
				dateFormat: 'd.m.Y'
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