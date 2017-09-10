Ext.define('Todoliste.store.Todos', {
  extend: 'Ext.data.ArrayStore',
  config: {
    data: [
      [ 'Dies' ],
      [ 'Das' ],
      [ 'Jenes' ]
    ],
    fields: [
      'title'
    ]
  }
});