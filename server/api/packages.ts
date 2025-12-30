import { packages } from '~/data/packages'
import type { EnrichedPackage } from '#shared/types/packages'

export default defineCachedEventHandler<Promise<EnrichedPackage[]>>(
    async () => {
        const enrichedPackages: EnrichedPackage[] = await Promise.all(
            packages
                .filter(pkg => pkg.visible)
                .map(async pkg => {
                    const [githubData, packagistData] = await Promise.all([
                        fetchRepositoryData(pkg.github.owner, pkg.github.repo),
                        pkg.packagistName ? fetchPackagistDownloads(pkg.packagistName) : null,
                    ])

                    return {
                        ...pkg,
                        stars: githubData?.stars || 0,
                        language: githubData?.language || undefined,
                        topics: githubData?.topics || [],
                        downloads: packagistData?.downloads || undefined,
                    } satisfies EnrichedPackage
                }),
        )

        // Sort by display name
        return enrichedPackages.sort((a, b) => a.name.localeCompare(b.name, 'en-US'))
    },
    {
        maxAge: 60 * 60 * 12, // Cache for 12 hours
        name: 'packages',
        getKey: () => 'all-packages',
    },
)
