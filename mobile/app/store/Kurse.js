Ext.define('Kursliste.store.Kurse', {
  extend: 'Ext.data.Store',
  requires: [
	'Ext.data.proxy.Rest'
  ],
  config: {
    proxy: {
		type: 'rest',
		url: '/fitnessportal/webservice/fitnesskurse',
		reader: {
			type: 'json'
		},
		listeners: {
			exception: function(proxy, response) {
				Ext.Msg.alert('Fehler', response.statusText);
			}
		}
	},
    model: 'Kursliste.model.Kurs',
	autoLoad: true
  }
});