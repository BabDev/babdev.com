import { packages } from '~/data/packages'
import type { EnrichedPackage } from '#shared/types/packages';

export default defineCachedEventHandler<Promise<EnrichedPackage[]>>(async () => {
    const enrichedPackages: EnrichedPackage[] = await Promise.all(
        packages.filter(pkg => pkg.visible)
            .map(async (pkg) => {
                const [githubData, packagistData] = await Promise.all([
                    fetchRepositoryData('BabDev', pkg.name),
                    pkg.packagistName
                        ? fetchPackagistDownloads(pkg.packagistName)
                        : null,
                ])

                return {
                    ...pkg,
                    stars: githubData?.stars || 0,
                    language: githubData?.language || null,
                    topics: githubData?.topics || [],
                    downloads: packagistData?.downloads || null,
                    githubUrl: `https://github.com/BabDev/${pkg.name}`,
                } satisfies EnrichedPackage
            })
    )

    // Sort by display name
    return enrichedPackages.sort((a, b) => a.displayName.localeCompare(b.displayName))
}, {
    maxAge: 60 * 60 * 12, // Cache for 12 hours
    name: 'packages',
    getKey: () => 'all-packages',
})
