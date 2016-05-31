import Ember from 'ember';

export default Ember.Controller.extend({
	selectAuthor: '1',

	actions:{

		addPost(){
			var title = this.get("postTitle");
			var content = this.get("postContent");
			var aid = this.selectAuthor;
			// alert("aid: "+aid);
			var post = this.store.createRecord('post',{
				"title":title,
				"body":content,
				"aid":aid
			});

			this.set("postTitle","");
			this.set("postContent","");
			post.save();
			//refresh data to avoid duplicate records on posts page
			location.reload();
		}

	}
});
