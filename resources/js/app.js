/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;




Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);

import Swal from 'sweetalert2';

import VueProgressBar from 'vue-progressbar'
import Loading from 'vue-loading-overlay';

Vue.use(Loading,{
    color:'#0b5ed7',
    width:'45px',
    height:'45px',
});

Vue.use(VueProgressBar, {
    color: '#0b5ed7',
    failedColor: 'red',
    height: '2px',
  })

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  


window.Swal = Swal;


const app = new Vue({
    el: '#app',
});
