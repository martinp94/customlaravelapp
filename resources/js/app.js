
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import moment from 'moment';
import Swal from 'sweetalert2';

window.swal = Swal;

const toastTopRight = Swal.mixin({
	position: 'top-end',
	type: 'success',
	title: 'Your work has been saved',
	showConfirmButton: false,
	timer: 1500,
	heightAuto: false
});

window.toastTopRight = toastTopRight;

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform';

import VueProgressBar from 'vue-progressbar';

window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router';

Vue.use(VueRouter);

let routes = [
	{path: '/dashboard', component: require('./components/Dashboard.vue') },
	{path: '/profile', component: require('./components/Profile.vue') },
	{path: '/users', component: require('./components/Users.vue') }
];

const router = new VueRouter({
	mode: 'history',
	routes
});

Vue.filter('myDate', (date) => {
	return moment(date).add(2, 'hours').format('DD. MMMM YYYY, hh:mm:ss');
});

const VueProgressBarOptions = {
  color: '#40e52d',
  failedColor: '#c11717',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  }
}

Vue.use(VueProgressBar, VueProgressBarOptions);

window.Fire = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router
});
