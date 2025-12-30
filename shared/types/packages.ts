export interface PackageVersion {
    version: string
    gitBranch: string | null
    released: string | null
    endOfSupport: string | null
}

export type PackageType = 'laravel-package' | 'symfony-bundle' | 'sylius-plugin' | 'php-package'

export interface Package {
    name: string
    displayName: string
    packagistName: string | null
    slug: string
    description: string | null
    packageType: PackageType | null
    hasDocumentation: boolean
    supported: boolean
    visible: boolean
    isPackagist: boolean
    versions: PackageVersion[]
}

export interface EnrichedPackage extends Package {
    stars: number
    language: string | null
    topics: string[]
    downloads: number | null
    githubUrl: string
}
