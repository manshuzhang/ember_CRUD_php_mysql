import Ember from 'ember';
import config from './config/environment';

const Router = Ember.Router.extend({
  location: config.locationType
});

Router.map(function() {
  this.route('authors');
  this.route('posts');
  this.route('author', {path:'/author/:id'});
  this.route('post', {path:'/post/:id'});
});

export default Router;
