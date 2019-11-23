Ext.define('Kursliste.view.Main', {
    extend: 'Ext.navigation.View',
	xtype: 'main',
	config: {
		items: {
			xtype: 'kurslist'
		},
		defaultBackButtonText: 'Zurück',
		navigationBar: {
			items: [
				{
					xtype: 'button',
					text: 'Löschen',
					align: 'right',
					id: 'deletebutton',
					hidden: true
				}
			]
		}
	}
});
