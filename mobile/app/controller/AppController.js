Ext.define('Kursliste.controller.AppController', {
  extend: 'Ext.app.Controller',
  config: {
	control: {
		kurslist: {
			itemtap: 'showKursDetails'
		},
		'#deletebutton': {
			tap: 'showConfirmDeleteDialog'
		},
		main: {
			push: 'showDeleteButton',
			pop: 'hideDeleteButton'
		}
		
	},
	refs: {
		main: 'main',
		todoForm: 'kursform',
		deleteButton: '#deletebutton'
	}
  },
  
  showKursDetails: function(list, index, target, record) {
	var main = this.getMain();
	var kursForm = Ext.widget('kursform');
	kursForm.setRecord(record);
	main.push(kursForm);
  },
  
  showConfirmDeleteDialog: function() {
	Ext.Msg.confirm('Löschen', 'Wirklich löschen?', this.deleteKurs, this);
  },
  
  deleteTodo: function(buttonId) {
	if (buttonId != 'yes') {
		return;
	}
	var kurs = this.getKursForm().getRecord();
	var kurse = Ext.getStore('Kurse');
	kurse.remove(kurs);
	kurse.sync({
		callback: function() {
			this.getMain().pop();
		},
		scope: this
	});
	},
	
	showDeleteButton: function() {
		this.getDeleteButton().setHidden(false);
	},
	hideDeleteButton: function() {
		this.getDeleteButton().setHidden(true);
	}
});