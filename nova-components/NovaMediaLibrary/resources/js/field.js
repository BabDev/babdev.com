import IndexField from './components/fields/IndexField.vue';
import DetailField from './components/fields/DetailField.vue';
import FormField from './components/fields/FormField.vue';

Nova.booting((Vue, router) => {
    Vue.component('index-media-library-field', IndexField);
    Vue.component('detail-media-library-field', DetailField);
    Vue.component('form-media-library-field', FormField);
});
