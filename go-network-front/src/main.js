import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'bootstrap/scss/bootstrap.scss';
import './assets/css/styles.scss';

createApp(App).use(router).mount('#app')
