Ext.define('Todoliste.store.Todos', {
  extend: 'Ext.data.Store',
  requires: [
	'Ext.data.proxy.Rest'
  ],
  config: {
    proxy: {
		type: 'rest',
		url: '/bangemann/5_WebService/todos',
		reader: {
			type: 'json'
		},
		listeners: {
			exception: function(proxy, response) {
				Ext.Msg.alert('Fehler', response.statusText);
			}
		}
	},
    model: 'Todoliste.model.Todo',
	autoLoad: true
  }
});