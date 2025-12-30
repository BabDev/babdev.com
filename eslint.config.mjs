import withNuxt from './.nuxt/eslint.config.mjs'
import eslintPluginPrettier from 'eslint-plugin-prettier/recommended'

export default withNuxt(eslintPluginPrettier)
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
