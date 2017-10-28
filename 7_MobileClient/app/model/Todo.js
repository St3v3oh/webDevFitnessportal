Ext.define('Todoliste.model.Todo', {
	extend: 'Ext.data.Model',
	config: {
		fields: [
		  'title',
		  'author',
		  {
			name: 'due_date',
			type: 'date'
		  },
		  'notes',
		  'version'
		],
		idProperty: 'url'
	}
});