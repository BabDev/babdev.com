# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Nuxt 4 application that powers the BabDev website (https://www.babdev.com), showcasing open-source PHP packages (Laravel, Symfony, Sylius) with integrated documentation.

## Commands

### Development
```bash
npm install              # Install dependencies
npm run dev              # Start dev server on http://localhost:3000
npm run build            # Build for production
npm run preview          # Preview production build locally
npm run generate         # Generate static site
```

### Code Quality
```bash
npm run lint             # Run ESLint
npm run lint:fix         # Fix ESLint issues automatically
npm run format           # Format code with Prettier
npm run format:check     # Check Prettier formatting
```

## Architecture

### Documentation System

The site fetches and displays documentation from GitHub repositories at build time:

1. **Package definitions** are centralized in `app/data/packages.ts` - this is the single source of truth for all packages, their versions, GitHub repos, and metadata.

2. **Build-time route discovery** (`scripts/discover-routes.ts`) crawls GitHub repos during prerendering to discover all documentation pages and generate static routes. Requires `GITHUB_TOKEN` environment variable.

3. **Documentation API** (`server/api/packages/[slug]/docs/[version]/[...path].ts`) fetches Markdown files from GitHub using the Octokit client, with 24-hour caching. Files are fetched from `docs/{path}.md` in the repository's branch corresponding to the version.

4. **GitHub utilities** (`server/utils/github.ts`) provide a singleton Octokit client and helpers for fetching repository metadata and file contents.

5. **Package data enrichment** (`server/api/packages.ts`) fetches GitHub stars/topics and Packagist download counts to enrich package metadata.

### Key Architectural Patterns

- **Static site generation (SSG)**: The site is fully prerendered with `nitro.static: true` and `autoSubfolderIndex: false` (no trailing slashes in URLs).
- **Trailing slash middleware**: `app/middleware/redirect-trailing-slash.global.ts` enforces no trailing slashes with 301 redirects.
- **MDC content rendering**: Uses `@nuxtjs/mdc` for Markdown rendering with custom Prose components in `app/components/prose/`.
- **Cached API handlers**: Documentation endpoints use `defineCachedEventHandler` with 24-hour cache TTL.
- **Type safety**: Shared TypeScript types in `shared/types/` define the package data structure used across client and server.

### Directory Structure

```
app/
  components/          # Vue components
    prose/            # Custom MDC prose components (*.global.vue)
  data/               # Package definitions (packages.ts)
  layouts/            # Layout components
  middleware/         # Global middleware (trailing slash redirect)
  pages/              # File-based routing
  assets/css/         # Global CSS (Tailwind)
server/
  api/                # Nitro API routes
  utils/              # Server utilities (GitHub, Packagist)
scripts/              # Build scripts (route discovery)
shared/types/         # Shared TypeScript interfaces
public/               # Static assets
```

### Configuration

- **Nuxt config** (`nuxt.config.ts`): Configures modules (@nuxt/eslint, @nuxt/fonts, @nuxt/icon, @nuxt/image, @nuxtjs/mdc, @nuxtjs/sitemap), Tailwind via Vite plugin, MDC syntax highlighting, and prerender hooks.
- **ESLint** (`eslint.config.mjs`): Extends Nuxt's config with Prettier integration, disables multi-word component names rule.
- **Prettier**: 4-space tabs, single quotes, 120 print width, Tailwind plugin for class sorting.
- **Environment variables**: `GITHUB_TOKEN` (required for build), `NUXT_PUBLIC_SITE_URL` (defaults to localhost:3000).

## Working with Packages

To add a new package:
1. Add entry to `app/data/packages.ts` with all required metadata
2. Ensure the GitHub repo has a `docs/` directory in the specified branch
3. The documentation will be automatically discovered and prerendered on next build

To modify documentation rendering:
- Edit Prose components in `app/components/prose/` (these override MDC defaults)
- Modify MDC config in `nuxt.config.ts` for syntax highlighting languages/themes

## Main Branch

The main branch is `production` (not `main` or `master`). All PRs should target this branch.
