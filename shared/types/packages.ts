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
