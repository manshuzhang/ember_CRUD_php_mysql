import DS from 'ember-data';

export default DS.JSONAPIAdapter.extend({
	// cross domain request for dev
	// host:"http://localhost:8888",
	// headers:{
	// 	"Accept":"application/vnd.api+json",
	// }
	// same domain request for deploy
	namespace: 'rest'
});
