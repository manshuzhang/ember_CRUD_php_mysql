import Ember from 'ember';

export default Ember.Component.extend({
	isEditing:false,
	actions:{
		editAuthor(){
			this.set('isEditing', true);
		},
		updateAuthor(author){
			author.save();
			this.set('isEditing', false);
		},
		delAuthor(author){
			var r = confirm("Are you sure");
			if (r === true) 
			{
				author.deleteRecord();
            	author.save();
			}
		}
	}
});
