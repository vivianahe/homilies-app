
import './assets/main.css';
import './assets/ckedoctor-reset.css';
import CKEditor from '@ckeditor/ckeditor5-vue';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import '@fortawesome/fontawesome-free/css/all.min.css';
import FullCalendar from '@fullcalendar/vue3'; // Importa FullCalendar
import dayGridPlugin from '@fullcalendar/daygrid'; // Importa el complemento de DayGrid
import interactionPlugin from '@fullcalendar/interaction'; // Importa el complemento de Interaction

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.use(FullCalendar);
app.use(CKEditor); // Usa FullCalendar como un complemento global

// Usa los complementos de FullCalendar
app.use(dayGridPlugin);
app.use(interactionPlugin);

app.mount('#app');

