module.exports = {
    plugins: [
        require('autoprefixer')(),
        require('@fullhuman/postcss-purgecss')({
            content: [
                'app/**/*.php',
                'resources/**/*.js',
                'resources/**/*.php',
                'vendor/babdev/laravel-breadcrumbs/**/*.php',
            ],
            defaultExtractor: (content) => content.match(/[\w-/.:]+(?<!:)/g) || [],
            // Allow highlight styles and styles used only in docs
            safelist: {
                standard: [
                    // highlight.js
                    /^.hljs/, /^.hljs-/, /^hljs/, /^hljs-/,
                    // SVG styling
                    /svg/,
                    // Bootstrap Tables
                    /^.table/, /^.table-/, /^table/, /^tr/, /^td/, /^th/, /^thead/, /^tbody/, /^tfoot/,
                    // App styles
                    /^docs-note/,
                ],
                deep: [
                    // highlight.js
                    /^.hljs/, /^.hljs-/, /^hljs/, /^hljs-/,
                    // SVG styling
                    /svg/,
                    // Bootstrap Tables
                    /^.table/, /^.table-/, /^table/, /^tr/, /^td/, /^th/, /^thead/, /^tbody/, /^tfoot/,
                    // App styles
                    /^docs-note/,
                ],
            },
        }),
    ],
};
