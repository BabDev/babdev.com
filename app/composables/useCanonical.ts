import type { MaybeRefOrGetter } from 'vue'

/**
 * Adds a `rel="canonical"` link for the current route, plus a `rel="alternate"; type="text/markdown"`
 * link when a Markdown twin is given, so an agent landing on the HTML page can find the raw representation.
 *
 * This mirrors the composable of the same name in `nuxt-agent-discovery`. That module is not installed: its
 * value is in content negotiation and CDN rewrites, which need a running server, and this site is fully
 * prerendered onto GitHub Pages. Keeping the same shape means the module can be adopted later without
 * touching the call sites. The absolute URL comes from the configured site URL rather than `useRequestURL()`
 * so that prerendering emits the public origin instead of the build-time one.
 */
export function useCanonical(markdownAlternate?: MaybeRefOrGetter<string | null | undefined>): void {
    const route = useRoute()
    const siteUrl = useRuntimeConfig().public.siteUrl.replace(/\/+$/, '')

    useHead({
        link: computed(() => {
            const markdown = toValue(markdownAlternate)

            return [
                { rel: 'canonical', href: `${siteUrl}${route.path}` },
                ...(markdown ? [{ rel: 'alternate', type: 'text/markdown', href: `${siteUrl}${markdown}` }] : []),
            ]
        }),
    })
}
