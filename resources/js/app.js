require('./bootstrap');

import { createApp } from 'vue'
import RegistrationForm from './components/RegistrationForm.vue';
import LoginForm from './components/LoginForm.vue';
import EditForm from './components/EditForm.vue';

createApp({
  components: { 
    RegistrationForm,
    LoginForm,
    EditForm,
  }
}).mount('#app')
