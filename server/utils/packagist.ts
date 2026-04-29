import { FetchError } from 'ofetch'

export async function fetchPackagistDownloads(packageName: string) {
    try {
        const data = await $fetch<{ downloads?: { total?: number } }>(
            `https://packagist.org/packages/${packageName}/stats.json`,
            {
                headers: {
                    'User-Agent': 'BabDev/2.0',
                },
            },
        )

        return {
            downloads: data.downloads?.total || 0,
        }
    } catch (error) {
        if (error instanceof FetchError) {
            console.error(
                `Failed to fetch Packagist data for ${packageName}: ${error.statusCode ?? 'unknown'} ${error.statusMessage ?? error.message}`,
                {
                    url: error.request,
                    data: error.data,
                },
            )
        } else {
            console.error(`Failed to fetch Packagist data for ${packageName}:`, error)
        }

        return null
    }
}
