Ext.define("Kursliste.view.KursList", {
	extend: 'Ext.dataview.List',
	xtype: 'kurslist',
	requires: [
		'Ext.plugin.PullRefresh'
	],
	config: {
		store: 'Kurse',
		itemTpl: '<div>{title}</div>',
		emptyText: 'keine Kurse',
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