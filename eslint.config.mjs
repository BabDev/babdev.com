import withNuxt from './.nuxt/eslint.config.mjs'

export default withNuxt()
    .override('nuxt/vue/rules', {
        rules: {
            'vue/multi-word-component-names': 'off',
        },
    })
    .override('nuxt/vue/single-root', {
        rules: {
            'vue/no-multiple-template-root': 'off',
        },
    })
