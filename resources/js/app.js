import './bootstrap';

import { formatDistance, subDays } from 'date-fns'

//alert(formatDistance(subDays(new Date(), 3), new Date(), { addSuffix: true }));

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import ExampleComponent from './components/ExampleComponent.vue';
import MainComponent from './components/MainComponent.vue';
import AdminComponent from './components/AdminComponent.vue';
import LinkComponent from './components/LinkComponent.vue';

createApp({
    components: {
        ExampleComponent,
        AdminComponent,
        MainComponent,
        LinkComponent
    }
}).mount('#app');