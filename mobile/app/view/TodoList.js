Ext.define("Todoliste.view.TodoList", {
	extend: 'Ext.dataview.List',
	xtype: 'todolist',
	requires: [
		'Ext.plugin.PullRefresh'
	],
	config: {
		store: 'Todos',
		itemTpl: '<div>{title}</div>',
		emptyText: 'keine Todos',
		plugins: [
			{
				type: 'pullrefresh',
				pullText: 'Zum Aktualisieren herunterziehen...',
				releaseText: 'Zum Aktualisieren loslassen...',
				loadingText: 'Laden...',
				loadedText: '',
				lastUpdatedText: '',
				lastUpdatedDateFormat: ' '
			}
		]
	}
});