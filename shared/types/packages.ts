export interface PackageVersion {
    version: string
    gitBranch?: string
    released: boolean
    endOfSupport?: string
}

export type PackageType = 'laravel-package' | 'symfony-bundle' | 'sylius-plugin' | 'php-package'

export interface Package {
    name: string
    slug: string
    // Slugs this package used to be published under, if it has ever been renamed. This is an append-only list.
    previousSlugs?: string[]
    description?: string
    github: {
        owner: string
        repo: string
    }
    packagistName?: string
    packageType: PackageType
    hasDocumentation: boolean
    supported: boolean
    visible: boolean
    versions: PackageVersion[]
}

export interface EnrichedPackage extends Package {
    stars: number
    language?: string
    topics: string[]
    downloads?: number
}
