import { packages } from '~/data/packages'
import type { Package } from '#shared/types/packages'

export default defineEventHandler(event => {
    setHeader(event, 'Content-Type', 'text/plain; charset=utf-8')

    const visiblePackages = packages.filter(pkg => pkg.visible)
    const supportedPackages = visiblePackages.filter(pkg => pkg.supported)
    const unsupportedPackages = visiblePackages.filter(pkg => !pkg.supported)
    const packagesWithDocs = visiblePackages.filter(pkg => pkg.hasDocumentation)

    const lines = [
        '# BabDev',
        '',
        '> Open source PHP packages for Laravel, Symfony, Sylius, and standalone PHP applications.',
        '',
        'This website provides documentation and information about open source PHP packages maintained by BabDev.',
        '',
        '## Main Sections',
        '',
        '- [Home](/): Welcome page',
        '- [Open Source Packages](/open-source/packages): List of all packages',
        '',
        '## Packages',
        '',
    ]

    // Group supported packages by type
    const packagesByType = new Map<string, Package[]>()

    for (const pkg of supportedPackages) {
        const typeLabel = getPackageTypeLabel(pkg.packageType)

        if (!packagesByType.has(typeLabel)) {
            packagesByType.set(typeLabel, [])
        }

        packagesByType.get(typeLabel)!.push(pkg)
    }

    // Sort alphabetically
    for (const typeLabel of [...packagesByType.keys()].sort((a, b) => a.localeCompare(b, 'en-US'))) {
        const pkgs = packagesByType.get(typeLabel)!
        lines.push(`### ${typeLabel}s`)
        lines.push('')

        for (const pkg of pkgs.sort((a, b) => a.name.localeCompare(b.name, 'en-US'))) {
            lines.push(`- ${pkg.name}${pkg.description ? `: ${pkg.description}` : ''}`)
        }

        lines.push('')
    }

    // List unsupported packages
    if (unsupportedPackages.length > 0) {
        lines.push('### No Longer Supported')
        lines.push('')

        for (const pkg of unsupportedPackages.sort((a, b) => a.name.localeCompare(b.name, 'en-US'))) {
            lines.push(`- ${pkg.name} (no longer supported)${pkg.description ? `: ${pkg.description}` : ''}`)
        }

        lines.push('')
    }

    // Add documentation section when available
    if (packagesWithDocs.length > 0) {
        lines.push('## Documentation')
        lines.push('')
        lines.push('The following packages have documentation available:')
        lines.push('')

        for (const pkg of packagesWithDocs.sort((a, b) => a.name.localeCompare(b.name, 'en-US'))) {
            const latestVersion = getLatestStablePackageVersion(pkg)

            if (latestVersion) {
                const unsupportedNote = pkg.supported ? '' : ' (no longer supported)'

                lines.push(
                    `- [${pkg.name} Documentation](/open-source/packages/${pkg.slug}/docs/${latestVersion.version}/intro)${unsupportedNote}`,
                )
            }
        }

        lines.push('')
    }

    return lines.join('\n')
})
