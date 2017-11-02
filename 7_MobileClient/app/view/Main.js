Ext.define('Todoliste.view.Main', {
    extend: 'Ext.navigation.View',
	xtype: 'main',
	config: {
		items: {
			xtype: 'todolist'
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
