import Ember from 'ember';

export default Ember.Controller.extend({
	
	actions:{
		addAuthor(){
			var firstName = this.get("firstName");
			var lastName = this.get("lastName");
			var author = this.store.createRecord('author',{
				"firstName":firstName,
				"lastName":lastName
			});

			this.set("firstName","");
			this.set("lastName","");
			author.save();
			//refresh data to avoid duplicate records on posts page
			location.reload();
		}
	}
});
