import CKEditor from 'ckeditor4-vue';
import IndexField from './components/IndexField.vue';
import DetailField from './components/DetailField.vue';
import FormField from './components/FormField.vue';

Nova.booting((Vue, router, store) => {
    Vue.use(CKEditor);

    Vue.component('index-nova-ckeditor4-field', IndexField);
    Vue.component('detail-nova-ckeditor4-field', DetailField);
    Vue.component('form-nova-ckeditor4-field', FormField);
});
