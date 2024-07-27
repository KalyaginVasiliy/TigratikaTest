import './bootstrap';
import { createApp } from 'vue';
import NomenclaturePage from './components/NomenclaturePage.vue';
import axios from 'axios';

// Добавление CSRF-токена в заголовки запросов, если элемент существует
const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
if (csrfTokenElement) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfTokenElement.content;
} else {
    console.warn('CSRF-токен не найден в мета-тегах.');
}

// Добавление заголовка Content-Type
axios.defaults.headers.common['Content-Type'] = 'application/json';

const app = createApp({});

app.component('nomenclature-page', NomenclaturePage);

app.mount('#app');
