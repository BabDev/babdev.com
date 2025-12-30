export async function fetchPackagistDownloads(packageName: string) {
    try {
        const response = await fetch(`https://packagist.org/packages/${packageName}/stats.json`, {
            headers: {
                'User-Agent': 'BabDev/2.0',
            },
        })

        if (!response.ok) {
            console.error(
                `Failed to fetch Packagist data for ${packageName}: API responded with status code ${response.status}`,
            )

            return null
        }

        const data = await response.json()

        return {
            downloads: data.downloads?.total || 0,
        }
    } catch (error) {
        console.error(`Failed to fetch Packagist data for ${packageName}:`, error)

        return null
    }
}
