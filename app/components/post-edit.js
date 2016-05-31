import Ember from 'ember';

export default Ember.Component.extend({
	isEditing:false,
	selectAuthor: '1',
	actions:{
		editToggle() {
	      this.set('isEditing', true);
	    },
	    updatePost(post){
			post.set('aid',this.selectAuthor);
			post.save();
			this.set('isEditing', false);
	    },
		delPost(post){
			var r = confirm("Are you sure");
			if (r === true) 
			{
				post.deleteRecord();
            	post.save();
			}
		}
	}
});
