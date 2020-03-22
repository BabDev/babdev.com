Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-media-library', require('./components/IndexField'))
  Vue.component('detail-nova-media-library', require('./components/DetailField'))
  Vue.component('form-nova-media-library', require('./components/FormField'))
})
