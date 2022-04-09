import IndexField from './components/IndexField';
import DetailField from './components/DetailField';
import FormField from './components/FormField';

Nova.booting(app => {
    app.component('index-tinymce-field', IndexField);
    app.component('detail-tinymce-field', DetailField);
    app.component('form-tinymce-field', FormField);
});
