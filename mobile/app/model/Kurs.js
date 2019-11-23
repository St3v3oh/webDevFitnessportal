Ext.define('Kursliste.model.Kurs', {
	extend: 'Ext.data.Model',
	config: {
		fields: [
		  'title',
		  'trainer',
		  {
			name: 'startdate',
			type: 'datetime'
		  },
          'notes',
          'duration',
          'numberOfPeople',
          'price',
		  'version'
		],
		idProperty: 'url'
	}
});