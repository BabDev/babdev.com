# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Nuxt 4 application that powers the BabDev website (https://www.babdev.com), showcasing open-source PHP packages (Laravel, Symfony, Sylius) with integrated documentation.

## Commands

### Development

```bash
pnpm install             # Install dependencies
pnpm dev                 # Start dev server on http://localhost:3000
pnpm build               # Build for production
pnpm preview             # Preview production build locally
pnpm generate            # Generate static site
```

### Code Quality

```bash
pnpm lint                # Run ESLint
pnpm lint:fix            # Fix ESLint issues automatically
pnpm format              # Format code with Prettier
pnpm format:check        # Check Prettier formatting
```

## Architecture

### Documentation System

The site fetches and displays documentation from GitHub repositories at build time:

1. **Package definitions** are centralized in `app/data/packages.ts` - this is the single source of truth for all packages, their versions, GitHub repos, and metadata.

2. **Build-time route discovery**: `discoverDocsRoutes()` in `server/utils/docs.ts` walks each repo's `docs/` tree on GitHub, and one list feeds both the prerenderer and the sitemap. The Nitro `prerender:routes` hook in `nuxt.config.ts` adds those routes plus each page's `/raw` Markdown twin and the redirect-source routes (package `/docs` indexes, renamed-slug URLs); `server/api/__sitemap__/docs.get.ts` serves the canonical subset of that list (`sitemapDocsRoutes()`) to the sitemap, which excludes the `nuxt:prerender` source so non-canonical copies stay out. `crawlLinks` picks up everything else. Every version of a page sets `rel="canonical"` to the latest stable version's copy when one exists (`canonicalDocsRoute()`), because successive versions are near-duplicates. Both need the `GITHUB_TOKEN` environment variable.

3. **Documentation API** (`server/api/packages/[slug]/docs/[version]/[...path].get.ts`) resolves a route to `docs/{path}.md` on the version's branch through `resolveDoc()` in `server/utils/docSource.ts`, which caches the GitHub fetch for 24 hours, then applies rendering-only workarounds to the Markdown. The raw twin (`server/routes/raw/open-source/packages/[slug]/docs/[version]/[...path].get.ts`, advertised by `server/routes/llms.txt.get.ts`) serves the same file verbatim through `resolveDoc()` for AI agents, so rendering workarounds stay out of that path.

4. **GitHub utilities** (`server/utils/github.ts`) provide a singleton Octokit client and helpers for fetching repository metadata and file contents.

5. **Package data enrichment** (`server/api/packages.get.ts`) fetches GitHub stars/topics and Packagist download counts to enrich package metadata.

### Key Architectural Patterns

- **Static site generation (SSG)**: The site is fully prerendered with `nitro.static: true` and `autoSubfolderIndex: false` (no trailing slashes in URLs).
- **Trailing slash middleware**: `app/middleware/redirect-trailing-slash.global.ts` enforces no trailing slashes with 301 redirects.
- **Comark content rendering**: Uses `@comark/nuxt` (the `<Markdown>` component, taking raw Markdown via `:value`) for Markdown rendering with custom Prose components in `app/components/prose/`. Syntax highlighting is configured per-page via Comark's `shiki` plugin, passed through the `:plugins` prop.
- **Cached API handlers**: Documentation endpoints use `defineCachedEventHandler` with 24-hour cache TTL.
- **Type safety**: Shared TypeScript types in `shared/types/` define the package data structure used across client and server.

### Directory Structure

```
app/
  components/          # Vue components
    prose/            # Custom Comark prose components (*.global.vue)
  composables/        # Composables (canonical + Markdown alternate links)
  data/               # Package definitions (packages.ts)
  middleware/         # Global middleware (trailing slash redirect)
  pages/              # File-based routing
  assets/css/         # Global CSS (Tailwind)
server/
  api/                # Nitro API routes (incl. __sitemap__ source)
  routes/             # Non-API routes (llms.txt, /raw Markdown twins)
  utils/              # Server utilities (GitHub, Packagist)
shared/types/         # Shared TypeScript interfaces
shared/utils/         # Shared helpers (auto-imported on client + server)
public/               # Static assets
```

### Configuration

- **Nuxt config** (`nuxt.config.ts`): Configures modules (@nuxt/eslint, @nuxt/fonts, @nuxt/icon, @nuxt/image, @comark/nuxt, @nuxtjs/sitemap, reka-ui/nuxt), Tailwind via Vite plugin, static prerendering (`nitro.static`, `crawlLinks`, `autoSubfolderIndex: false`), route rules (redirects + prerender), fonts, and sitemap.
- **ESLint** (`eslint.config.mjs`): Extends Nuxt's config with Prettier integration, disables the multi-word component names and single-root template rules.
- **Prettier**: 4-space tabs, single quotes, 120 print width, Tailwind plugin for class sorting.
- **Environment variables**: `GITHUB_TOKEN` (needed for build; the build does not fail without it: GitHub errors, including unauthenticated rate limits, are logged and the affected docs pages are skipped, so check the prerender output — locally, `GITHUB_TOKEN="$(gh auth token)" pnpm build`), `NUXT_PUBLIC_SITE_URL` (defaults to localhost:3000).

## Working with Packages

To add a new package:

1. Add entry to `app/data/packages.ts` with all required metadata
2. Ensure the GitHub repo has a `docs/` directory in the specified branch
3. The documentation will be automatically discovered and prerendered on next build

To modify documentation rendering:

- Edit Prose components in `app/components/prose/` (these override Comark's default element rendering)
- Adjust the Comark `shiki` plugin config in the docs page (`app/pages/open-source/packages/[slug]/docs/[version]/[...path].vue`) for syntax highlighting languages/themes

## Main Branch

The main branch is `production` (not `main` or `master`). All PRs should target this branch.
