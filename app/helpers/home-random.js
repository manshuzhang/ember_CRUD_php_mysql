import Ember from 'ember';

export function homeRandom() {
	var myArray = ['<img class="emoji" draggable="false" alt="🚞" src="http://twemoji.maxcdn.com/72x72/1f69e.png" width="20px;">','<img class="emoji" draggable="false" alt="😃" src="http://twemoji.maxcdn.com/72x72/1f603.png" width="20px;">','<img class="emoji" draggable="false" alt="🚴" src="http://twemoji.maxcdn.com/72x72/1f6b4.png" width="20px;">','<img class="emoji" draggable="false" alt="🍟" src="http://twemoji.maxcdn.com/72x72/1f35f.png" width="20px;">'];
	
	return new Ember.Handlebars.SafeString(myArray[Math.floor(Math.random() * myArray.length)]);
	
}

export default Ember.Helper.helper(homeRandom);
